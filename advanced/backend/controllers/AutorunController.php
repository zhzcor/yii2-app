<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Order;
use common\models\OrderHistory;
use common\models\Wallet;
use common\models\WalletDetail;
use common\models\Notify;
use common\helpers\JpushHelper;
use common\models\Setting;
use common\models\User;
use common\models\Sender;
use yii\helpers\BaseJson;
use common\models\OrderPush;
use common\models\Brokerage;

/**
 * Class H5Controller app H5页面
 * @package backend\controllers
 */
class AutorunController extends Controller
{
   
    
    /**
     * 订单未抢单超时48小时，自动退单
     */
    public function actionReturnorder(){
        $ordreList = Order::find()->where(['order_status_id'=>20])
        ->andWhere(['delivery_user_id'=>0])
        ->andWhere(['<' , 'created_at' , time()-48*60*60])
        ->all();
        Yii::info('start' , 'order_cancel');
        if(!empty($ordreList)){
            foreach ($ordreList as $info){
                
                Yii::info('order_id:'.$info->id , 'order_cancel');
                try {
                    $info->order_status_id = '60';
                    if($info->save()){
                        //添加状态记录
                        OrderHistory::add($info->id, $info->order_status_id , '超48小时未抢单自动取消');
                        //退款到余额
                        $walletId = Wallet::change($info->total , $info->user_id);
                        if($walletId){
                            //添加明细
                            WalletDetail::add([
                                'wallet_id' => $walletId,
                                'user_id'   => $info->user_id,
                                'money'     => $info->total,
                                'event'     => '订单退款',
                                'carrier'   => '余额',
                                'orderno'   => $info->serial_no,
                                'status'    => 1
                            ]);
                            //添加账户通知
                            $content1 = '您的'.$info->serial_no.'编号订单已退款成功，请查看您的账户';
                            $notifyid1 = Notify::add($info->user_id, 'account', '退款通知' , $content1);
                            //添加寄件人通知
                            $content2 = '您的'.$info->serial_no.'编号订单因超48小时未抢单已被自动取消，款项已自动退回余额';
                            $notifyid2 = Notify::add($info->user_id, 'shipment', '订单取消通知' , $content2 , $info->id);
                            
                            //推送退款通知
                            $alias = ['type'=>'alias' , 'data'=>[$info->user_id.'id'.$info->user_id]];
                            //开始推送
                            $jpush = new JpushHelper();
                            //推送内容
                            $datas = ['type'=>'13' , 'id'=>$info->id , 'notify_id'=>$notifyid1 , 'content'=>$content1];
                            //执行推送
                            $jpush->push('您有新的账户通知', $datas , $alias);
                            
                            //推送订单取消通知
                            $alias = ['type'=>'alias' , 'data'=>[$info->user_id.'id'.$info->user_id]];
                            //推送内容
                            $datas = ['type'=>'24' , 'id'=>$info->id , 'notify_id'=>$notifyid2  , 'content'=>$content2];
                            //执行推送
                            $jpush->push('您有新的寄件通知', $datas , $alias);
                            
                            Yii::info('result:ok'.PHP_EOL , 'order_cancel');
                        }else{
                            Yii::info('result:fail'.PHP_EOL , 'order_cancel');
                        }
                    }
                } catch (\Exception $e) {
                    Yii::info('result:fail' , 'order_cancel');
                    Yii::info('exception:'.$e->getMessage().PHP_EOL , 'order_cancel');
                }
            }
        }
        Yii::info('end' , 'order_cancel');
    }
    
    
    /**
     * 订单寄件人未确认送达超48小时，自动完成
     */
    public function actionFinishorder(){
        Yii::info('start' , 'order_finish');
        $ordreList = Order::find()->where(['order_status_id'=>80])
        ->andWhere(['<' , 'arrived_at' , time()-48*60*60])
        ->all();
        if($ordreList){
            $jpush = new JpushHelper();
            foreach ($ordreList as $info){
                try {
                    $info->order_status_id = 50;
                    $info->finished_at = time();
                    if($info->save()){
                        Yii::info('order_id:'.$info->id , 'order_finish');
                        //添加状态记录
                        OrderHistory::add($info->id, $info->order_status_id);
                        //添加推送
                        $userInfo = User::findOne($info->user_id);
                        //平台手续费比例
                        $setting = Setting::_get('fees_percent');
                        //有推荐用户，抽取佣金
                        if($userInfo->recom_user_id != 0){
                            $recomInfo = User::findOne($userInfo->recom_user_id);
                            if(!empty($recomInfo)){
                                $rewardPercent = Setting::_get('reward_percent');
                                if(floatval($rewardPercent)){
                                    //佣金金额
                                    $money = round(floatval($info->postfee*(floatval($setting)/100)) * floatval($rewardPercent)/100 , 2);
                                    //添加佣金记录
                                    Brokerage::add($recomInfo->id, $info->id , $money);
                                    //金额存至到余额
                                    $walletId = Wallet::change($money , $recomInfo->id);
                                    if($walletId){
                                        //添加明细
                                        WalletDetail::add([
                                            'wallet_id' => $walletId,
                                            'user_id'   => $recomInfo->id,
                                            'money'     => $money,
                                            'event'     => '佣金',
                                            'carrier'   => '余额',
                                            'orderno'   => $info->serial_no,
                                            'status'    => 1
                                        ]);
                                    }
                                    //添加获得佣金通知
                                    $content = '您推荐的用户'.($userInfo->nickname ? $userInfo->nickname : $userInfo->telephone).'订单已确定送达，您获得佣金'.$money.'元，款项已存入您的余额';
                                    $notifyid1 = Notify::add($recomInfo->id, 'account', '获得佣金通知' , $content);
                                    //推送佣金通知
                                    $alias = ['type'=>'alias' , 'data'=>[$recomInfo->id.'id'.$recomInfo->id]];
                                    //推送内容
                                    $datas = ['type'=>'15' , 'notify_id'=>$notifyid1 , 'content'=>$content];
                                    //执行推送
                                    $jpush->push('您有新的账户通知', $datas , $alias);
                                }
                            }
                        }
                        //帮送员收益
                        $deliver_money = $info->postfee*(1-floatval($setting)/100);
                        //帮送员金额入账
                        $dUserInfo = User::findOne($info->delivery_user_id);
                        //金额存至到余额
                        $walletId = Wallet::change($deliver_money , $dUserInfo->id);
                        if($walletId){
                            //添加明细
                            WalletDetail::add([
                                'wallet_id' => $walletId,
                                'user_id'   => $dUserInfo->id,
                                'money'     => $deliver_money,
                                'event'     => '订单收益',
                                'carrier'   => '余额',
                                'orderno'   => $info->serial_no,
                                'status'    => 1
                            ]);
                        }
                        //添加获得收益通知
                        $content = '您配送的订单'.$info->serial_no.'已确定送达，获得收益'.$deliver_money.'元，款项已存入您的余额';
                        $notifyid1 = Notify::add($dUserInfo->id, 'account', '获得收益通知' , $content);
                        //推送收益通知
                        $alias = ['type'=>'alias' , 'data'=>[$dUserInfo->id.'id'.$dUserInfo->id]];
                        //推送内容
                        $datas = ['type'=>'14' , 'notify_id'=>$notifyid1 , 'content'=>$content];
                        //执行推送
                        $jpush->push('您有新的账户通知', $datas , $alias);
                        
                        Yii::info('result:ok'.PHP_EOL , 'order_finish');
                    }
                }catch (\Exception $e) {
                    Yii::info('result:fail' , 'order_finish');
                    Yii::info('exception:'.$e->getMessage().PHP_EOL , 'order_finish');
                }
            }
        }
    }
    
    /**
     * 可抢订单超10分钟，自动重推
     */
    public function actionRepushorder(){
        Yii::info('start' , 'order_repush');
        $ordreList = Order::find()->where(['order_status_id'=>20])
        ->andWhere(['delivery_user_id'=>0])
        ->andWhere(['<' , 'pushed_times' , 3])
        ->andWhere(['<' , 'pushed_at' , time()-10*60])
        ->andWhere(['>' , 'created_at' , time()-48*60*60])
        ->all();
        if(!empty($ordreList)){
            foreach ($ordreList as $info){
                $this->pushToDelivers($info);
                $info->pushed_at = time();
                $info->pushed_times = $info->pushed_times + 1;
                $info->save();
            }
        }
        Yii::info('end'.PHP_EOL , 'order_repush');
    }
    
    
    /**
     * 推送信息给帮送员用户
     */
    private function pushToDelivers($orderInfo){
        //配置的推送范围KM
        $range = Setting::_get('push_range');
        //获取范围内帮送员
        $userList = User::find()->where(['deliver'=>'1'])
        ->andWhere(['<>' , 'id' , $orderInfo->user_id])
        ->andWhere("ROUND(6378.138*2*ASIN(SQRT(POW(SIN((".$orderInfo['send_latitude']."*PI()/180-latitude*PI()/180)/2),2)+COS(".$orderInfo['send_latitude']."*PI()/180)*COS(latitude*PI()/180)* POW(SIN((".$orderInfo['send_longitude']."*PI()/180-longitude*PI()/180)/2),2))))<=".intval($range))
        ->select(['id'])->asArray()->all();
        
        Yii::info('order_id:'.$orderInfo->id , 'order_repush');
        
        //机器别名
        $alias = [];
        $alias['type'] = 'alias';
        $alias['data'] = [];
        $pushUsers = [];
        if($userList){
            foreach ($userList as $user){
                $alias['data'][] = $user['id']."id".$user['id'];
                $pushUsers[] = $user['id'];
            }
        }
        
        Yii::info('push-alias:'.BaseJson::encode($alias) , 'order_repush');
        
        if(!empty($alias['data'])){
            //开始推送
            $jpush = new JpushHelper();
            //推送内容
            $data = ['type'=>'order' , 'id'=>$orderInfo->id];
            //执行推送
            $response  = $jpush->push('您有新的可抢订单', $data , $alias);
            //记录推送记录
            if($pushUsers){
                foreach ($pushUsers as $pushId){
                    if(empty(OrderPush::findOne(['order_id'=>$orderInfo->id , 'user_id'=>$pushId]))){
                        $orderPush = new OrderPush();
                        $orderPush->order_id = $orderInfo->id;
                        $orderPush->user_id  = $pushId;
                        $orderPush->status   = 0;
                        $orderPush->save();
                    }
                }
            }
            Yii::info('push-response:'. BaseJson::encode($response) , 'order_repush');
        }
    }
    
}