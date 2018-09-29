<?php
return [
    'adminEmail'   => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    
    //极光推送配置
    'jpush_config' => [
        'app_key' => 'a6b40e6b64fdaf79395037da',
        'master_secret' => '43dcf8dfc4f615f4cfa02ea3',
        'registration_id' => '',
    ],
    
    //性别
    'sex'=>[
        'M' => '男',
        'F' => '女',
    ],
    
    //图片尺寸
    'image_size' => [
        'big'   => ['width'=>640 , 'height'=>640],
        'mid' => ['width'=>320 , 'height'=>320],
        'thumb' => ['width'=>150 , 'height'=>150],
        'small'   => ['width'=>90 , 'height'=>90],
    ],
    
    //用户身份类型
    'user_type' => [
        'sender' => '寄件人',
        'receiver' => '收件人',
        'deliver' => '送件人',
    ],
    
    'account_type' => [
        'alipay' =>'支付宝',
        'wxpay' => '微信'
    ],
    
    //发票类型
    'invoice_type' => [
        'personal' => '个人',
        'normal' => '普通',
        'profession' => '专票',
    ],
    
    'productStatus'=>[
        '1' => '已上架',
        '0' => '已下架',
    ],
    
    //审核状态
    'auditStatus' => [
        '0' => '未审核',
        '1' => '审核通过',
        '2' => '审核拒绝',
    ],
    //优惠券类型
    'couponType' =>[
        '1' => '满减',
        '2' => '折扣',
    ],
    
    //交易类型
    'walletType' =>[
        'logistic' => '帮我送',
        'shop' => '技能帮',
    ]
];
