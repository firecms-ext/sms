<?php

declare(strict_types=1);
/**
 * This file is part of FirecmsExt Sms.
 *
 * @link     https://www.klmis.cn
 * @document https://www.klmis.cn
 * @contact  zhimengxingyun@klmis.cn
 * @license  https://github.com/firecms-ext/sms/blob/master/LICENSE
 */
return [
    'timeout' => 5.0,

    'default' => [
        'strategy' => \FirecmsExt\Sms\Strategies\OrderStrategy::class,
        'senders' => ['log', 'tencent_cloud', 'rong_cloud', 'aliyun'],
    ],

    'senders' => [
        'tencent_cloud' => [
            'driver' => \FirecmsExt\Sms\Drivers\TencentCloudDriver::class,
            'config' => [
                'sdk_app_id' => '',
                'secret_id' => '',
                'secret_key' => '',
                'sign' => null,
                'from' => [ // sender_id
                    'default' => '',
                    // 'another' => '',
                ],
            ],
        ],

        'aliyun' => [
            'driver' => \FirecmsExt\Sms\Drivers\AliyunDriver::class,
            'config' => [
                'access_key_id' => '',
                'access_key_secret' => '',
                'sign_name' => '',
            ],
        ],

        'baidu_cloud' => [
            'driver' => \FirecmsExt\Sms\Drivers\BaiduCloudDriver::class,
            'config' => [
                'ak' => '',
                'sk' => '',
                'invoke_id' => '',
                'domain' => '',
            ],
        ],

        'huawei_cloud' => [
            'driver' => \FirecmsExt\Sms\Drivers\HuaweiCloudDriver::class,
            'config' => [
                'endpoint' => '',
                'app_key' => '',
                'app_secret' => '',
                'from' => [
                    'default' => '',
                    // 'another' => '',
                ],
            ],
        ],

        'juhe_data' => [
            'driver' => \FirecmsExt\Sms\Drivers\JuheDataDriver::class,
            'config' => [
                'app_key' => '',
            ],
        ],

        'qiniu' => [
            'driver' => \FirecmsExt\Sms\Drivers\QiniuDriver::class,
            'config' => [
                'secret_key' => '',
                'access_key' => '',
            ],
        ],

        'rong_cloud' => [
            'driver' => \FirecmsExt\Sms\Drivers\RongCloudDriver::class,
            'config' => [
                'app_key' => '',
                'app_secret' => '',
            ],
        ],

        'ronglian' => [
            'driver' => \FirecmsExt\Sms\Drivers\RonglianDriver::class,
            'config' => [
                'app_id' => '',
                'account_sid' => '',
                'account_token' => '',
                'is_sub_account' => false,
            ],
        ],

        'sms_bao' => [
            'driver' => \FirecmsExt\Sms\Drivers\SmsBaoDriver::class,
            'config' => [
                'user' => '',
                'password' => '',
            ],
        ],

        'yunpian' => [
            'driver' => \FirecmsExt\Sms\Drivers\YunpianDriver::class,
            'config' => [
                'api_key' => '',
                'signature' => '',
            ],
        ],

        'yunxin' => [
            'driver' => \FirecmsExt\Sms\Drivers\YunxinDriver::class,
            'config' => [
                'app_key' => '',
                'app_secret' => '',
                'code_length' => 4,
                'need_up' => false,
            ],
        ],

        'log' => [
            'driver' => \FirecmsExt\Sms\Drivers\LogDriver::class,
            'config' => [
                'name' => 'sms.local',
                'group' => 'default',
            ],
        ],
    ],

    'default_mobile_number_region' => null,
];
