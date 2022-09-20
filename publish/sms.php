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
                'sdk_app_id' => env('SMS_TENCENT_SDK_APP_ID', ''),
                'secret_id' => env('SMS_TENCENT_SECRET_ID', ''),
                'secret_key' => env('SMS_TENCENT_SECRET_KEY', ''),
                'sign' => env('SMS_TENCENT_SIGN', ''),
                'from' => [
                    'sender_id' => env('SMS_TENCENT_SENDER_ID', ''),
                    'default' => env('SMS_TENCENT_DEFAULT', ''),
                    'another' => env('SMS_TENCENT_ANOTHER', ''),
                ],
            ],
        ],

        'aliyun' => [
            'driver' => \FirecmsExt\Sms\Drivers\AliyunDriver::class,
            'config' => [
                'access_key_id' => env('SMS_ALIYUN_ACCESS_KEY_ID', ''),
                'access_key_secret' => env('SMS_ALIYUN_ACCESS_KEY_SECRET', ''),
                'sign_name' => env('SMS_ALIYUN_SIGN_NAME', ''),
            ],
        ],

        'baidu_cloud' => [
            'driver' => \FirecmsExt\Sms\Drivers\BaiduCloudDriver::class,
            'config' => [
                'ak' => env('SMS_BAIDU_AK', ''),
                'sk' => env('SMS_BAIDU_SK', ''),
                'invoke_id' => env('SMS_BAIDU_INVOKE_ID', ''),
                'domain' => env('SMS_BAIDU_DOMAIN', ''),
            ],
        ],

        'huawei_cloud' => [
            'driver' => \FirecmsExt\Sms\Drivers\HuaweiCloudDriver::class,
            'config' => [
                'endpoint' => env('SMS_HUAWEI_ENDPOINT', ''),
                'app_key' => env('SMS_HUAWEI_APP_KEY', ''),
                'app_secret' => env('SMS_HUAWEI_APP_SECRET', ''),
                'from' => [
                    'default' => env('SMS_HUAWEI_DEFAULT', ''),
                    'another' => env('SMS_HUAWEI_ANOTHER', ''),
                ],
            ],
        ],

        'juhe_data' => [
            'driver' => \FirecmsExt\Sms\Drivers\JuheDataDriver::class,
            'config' => [
                'app_key' => env('SMS_JUHE_APP_KEY', ''),
            ],
        ],

        'qiniu' => [
            'driver' => \FirecmsExt\Sms\Drivers\QiniuDriver::class,
            'config' => [
                'secret_key' => env('SMS_JUHE_SECRET_KEY', ''),
                'access_key' => env('SMS_JUHE_ACCESS_KEY', ''),
            ],
        ],

        'rong_cloud' => [
            'driver' => \FirecmsExt\Sms\Drivers\RongCloudDriver::class,
            'config' => [
                'app_key' => env('SMS_RONG_APP_KEY', ''),
                'app_secret' => env('SMS_RONG_APP_SECRET', ''),
            ],
        ],

        'ronglian' => [
            'driver' => \FirecmsExt\Sms\Drivers\RonglianDriver::class,
            'config' => [
                'app_id' => env('SMS_RONGLIAN_APP_ID', ''),
                'account_sid' => env('SMS_RONGLIAN_ACCOUNT_SID', ''),
                'account_token' => env('SMS_RONGLIAN_ACCOUNT_TOKEN', ''),
                'is_sub_account' => false,
            ],
        ],

        'sms_bao' => [
            'driver' => \FirecmsExt\Sms\Drivers\SmsBaoDriver::class,
            'config' => [
                'user' => env('SMS_BAO_USER', ''),
                'password' => env('SMS_BAO_PASSWORD', ''),
            ],
        ],

        'yunpian' => [
            'driver' => \FirecmsExt\Sms\Drivers\YunpianDriver::class,
            'config' => [
                'api_key' => env('SMS_YUNPIAN_API_KEY', ''),
                'signature' => env('SMS_YUNPIAN_SIGNATURE', ''),
            ],
        ],

        'yunxin' => [
            'driver' => \FirecmsExt\Sms\Drivers\YunxinDriver::class,
            'config' => [
                'app_key' => env('SMS_YUNXIN_APP_KEY', ''),
                'app_secret' => env('SMS_YUNXIN_APP_SECRET', ''),
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
