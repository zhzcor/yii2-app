<?php
namespace backend\models;

use Yii;
use common\models\BaseModel;
use common\models\SmsMobile;
use backend\models\User;
use common\helpers\Helper;
use common\models\Wallet;
use common\models\Order;
use api\models\LoginForm;

/**
 * Login form
 */
class FastSignupForm extends BaseModel
{
    public $telephone;
    
    public $verifycode;

    private $_user;

    const GET_API_TOKEN = 'generate_api_token';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // telephone required
            [['telephone'], 'required','message'=>'请输入{attribute}'],
            [['verifycode'], 'required','message'=>'请发送验证码'],
            [['telephone'], 'match', 'pattern'=>'/^1[0-9]{10}$/','message'=>'{attribute}格式不正确'],
            ['verifycode', 'validateVerifycode'],
            ['telephone', 'validateTelephone'],
        ];
    }
    
    public function init()
    {
        parent::init();
        $this->on(self::GET_API_TOKEN, [$this, 'onGenerateApiToken']);
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'telephone' => '手机号',
        ];
    }
    
    
    /**
     * 验证验证码
     * @param unknown $attribute
     * @param unknown $params
     */
    public function validateVerifycode($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $smsInfo = SmsMobile::findOne(['type'=>'signup','mobile'=>$this->telephone]);
            if (!$smsInfo) {
                $this->addError($attribute , '请发送验证码');
            }elseif($smsInfo->expired_at < time()){
                $this->addError($attribute , '验证码已过期，请重新发送验证码');
            }elseif($smsInfo->verify_code != $this->verifycode){
                $this->addError($attribute , '验证码错误');
            }
        }
    }
    
    
    /**
     * 验证手机号
     * @param unknown $attribute
     * @param unknown $params
     */
    public function validateTelephone($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::findByTelephone($this->telephone);
            if (!empty($user)) {
                $this->addError($attribute , '该手机号已注册');
            }
        }
    }
    
    
    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function signup($recom_user_id = '')
    {
        if ($this->validate()) {
            $user = new User();
            $user->telephone = $this->telephone;
            $user->password = Helper::generRandChar(6);
            if($recom_user_id){
                $user->recom_user_id = $recom_user_id;
            }
            if($user->save()){
                //创建钱包
                $wallet = new Wallet();
                $wallet->user_id = $user->id;
                $wallet->save();
                $user->wallet_id = $wallet->id;
                $user->save();
                //是否有收货人是我的订单有则绑定收货人ID
                $order = new Order();
                $orders = $order->getReceiverOrders($user->telephone);
                if(!empty($orders)){
                    $orderIds = [];
                    foreach ($orders as $ord){
                        $orderIds[] = $ord['id'];
                    }
                    $order->updateAll(['rec_user_id'=>$user->id] , ['id'=>$orderIds]);
                }
                //登录
                $model = new LoginForm();
                $model->telephone = $user->telephone;
                $model->password = $user->password;
                $this->_user = $model->login();
            }
            return $this->_user;
        } else {
            return null;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->telephone);
        }

        return $this->_user;
    }
    
    
    /**
     * 登录校验成功后，为用户生成新的token
     * 如果token失效，则重新生成token
     */
    public function onGenerateApiToken()
    {
        if (!User::apiTokenIsValid($this->_user->access_token)) {
            $this->_user->generateApiToken();
            $this->_user->save(false);
        }
    }
}
