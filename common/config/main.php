<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'name' => 'Feehi CMS',
    'version' => '0.0.8',
    'components' => [

        'cache' => [
            'class' => 'yii\caching\DummyCache',
        ],
        'formatter' => [
            'dateFormat' => 'php:Y-m-d H:i',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'CHY',
            'nullDisplay' => '-',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' =>false,//false发送邮件，true只是生成邮件在runtime文件夹下，不发邮件
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.feehi.com',  //每种邮箱的host配置不一样
                'username' => 'admin@feehi.com',
                'password' => 'password',
                'port' => '586',
                'encryption' => 'tls',
            ],
            'messageConfig'=>[
                'charset'=>'UTF-8',
                'from'=>['admin@feehi.com'=>'Feehi CMS robot ']
            ],
        ],
        'view' => [
            'class' => 'feehi\components\View',
        ],
        'feehi' => [
            'class' => 'feehi\components\Feehi',
        ],
        'alioss' => [
            'class' => 'feehi\components\Alioss',
            'enable' => false,
            'accessKeyId' => "xxx",
            'accessKeySecret' => "xxxx",
            'endpoint' => "http://oss-cn-shanghai.aliyuncs.com",
            'bucket' => 'feehi',
            'directory' => 'cms'
        ],
        'qiniu' => [
            'enable' => false,
            'class' => 'feehi\components\Qiniu',
            'accessKey' => 'giJQSarbtz7xk09mzNj1T8MLhCeXTOrHPj9-Sq_2',
            'secretKey' => '7nGQ3C_0xOWPxOtXev381psCC4AxSoSJpr4LCY4b',
            'bucket' => 'test',
            'directory' => 'cms',
        ],
    ],
];
