<?php
return [
    'adminRoleName' => 'administrator',                 // 超级管理员角色名
    'adminEmail' => 'admin@example.com',                // 管理员邮箱
    'cacheTime'  => 86400,                              // 用户登录的缓存时间
    'status'     => ['停用', '启用'],                   // 通用状态
    'projectName' => '企业查询',               // 项目名称
    'projectTitle' => '企业查询',
    'companyName' => '<span class="blue bolder"> Liujinxing </span> 企业查询 项目 &copy; 2016-2018',
    'iframeNumberSize' => 8,                           // 允许页面打开几个iframe窗口
    
    
    //地区级别
    'zone_level'=>[
        '' => '请选择',
        '1' => '国家级',
        '2' => '省/市级',
        '3' => '市级',
        '4' => '区级',
    ],
    
    //用户状态
    'userStatus'=>[
        '' => '请选择',
        '10' => '启用',
        '0' => '禁用'
    ],
    
    //可用状态
    'availableStatus'=>[
        '' => '请选择',
        '1' => '启用',
        '0' => '禁用'
    ],
    
    //性别
    'userSex'=>[
        '' => '请选择',
        'F' => '女',
        'M' => '男'
    ],
    
    //发票状态
    'posted_status'=>[
        '' => '请选择',
        '0' => '开票中',
        '1' => '已开票',
        '2' => '开票失败',
    ],
    
    //发票类型
    'invoiceType' => [
        '' => '请选择',
        'personal' => '个人',
        'normal' => '普通',
        'profession' => '专票',
    ],
    
    //是否选择
    'yesOrNo' => [
        '' => '请选择',
        '0' => '否',
        '1' => '是',
    ],
    
    //是否选择
    'notify_status' => [
        '' => '请选择',
        '0' => '未读',
        '1' => '已删除',
    ],
    
    //是否选择
    'product_status' => [
        '' => '请选择',
        '0' => '已下架',
        '1' => '已上架',
    ],
    
    //是否选择
    'dealStatus' => [
        '' => '请选择',
        '0' => '未处理',
        '1' => '已处理',
    ],
    
    //审核状态
    'audit_status' => [
        '' => '请选择',
        '0' => '未审核',
        '1' => '审核通过',
        '2' => '审核拒绝',
    ],
    
    'searchAccountType' => [
        '' => '请选择',
        'alipay' =>'支付宝',
        'wxpay' => '微信'
    ],
    
    'walletStatus' => [
        '' => '请选择',
        '0' => '未完成',
        '1' => '交易成功',
        '2' => '交易失败'
    ],
    
    //全球地区
    'areaCode' => [
        'Asia' => '亚洲地区',
        'America' => '美洲地区',
        'Europe' => '欧洲地区',
        'Africa' => '非洲地区',
        'Australia' => '澳洲地区'
    ],
    
    'ratingLevel' => [
        '' => '请选择',
        '1' => '一星',
        '2' => '二星',
        '3' => '三星',
        '4' => '四星',
        '5' => '五星',
    ],
    
    //优惠券类型
    'coupon_type' =>[
        '' => '请选择',
        '1' => '满减',
        '2' => '折扣',
    ],
    
    //交易类型
    'wallet_type' =>[
        '' => '请选择',
        'logistic' => '帮我送',
        'shop' => '技能帮',
    ]
];
