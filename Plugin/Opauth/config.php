
<?php
// 各プロバイダ毎のAPIキー
$config = [
    'security_salt' => '2sBz1U5epdrtub6DQH26MfzhXAehaf1H55SRwTBu', // レスポンスのシグネチャ生成に使うソルト値(ランダム文字列)
    'path' => '/auth/',
    'callback_url' => '/auth/complete', // Opauthのソーシャルログイン処理完了後にリダイレクトするURL
    'Strategy' => [
        'Yahoojp' => [
            'client_id' => 'xxx',
            'client_secret' => 'xxx'
        ],
        'Facebook' => [
            'app_id' => '1611552788953011',
            'app_secret' => 'c269a9661f08729e653c4732134e75e7',
            'scope' => 'email',
            'fields' => 'email,first_name,last_name,name'
        ],
        'Google' => [
            'client_id' => 'xxx',
            'client_secret' => 'xxx'
        ],
        'Twitter' => [
            'key' => 'zOKTxAKJk4AhGjVRwrz2IAuCb',
            'secret' => 'vC1myTCqzCqSYFIUnc08Q2hlO2ulupwYrOmF0NlML33ncPLrr7'
        ]
    ]
];
