
<?php
// 各プロバイダ毎のAPIキー
$config = [
    'security_salt' => '2sBz1U5epdrtub6DQH26MfzhXAehaf1H55SRwTBu', // レスポンスのシグネチャ生成に使うソルト値(ランダム文字列)
    'path' => '/auth/',
    'callback_url' => '/auth/complete', // Opauthのソーシャルログイン処理完了後にリダイレクトするURL
    'Strategy' => [
        'Facebook' => [
            'app_id' => '1611552788953011',
            'app_secret' => '', //シークレットを設定
            'scope' => 'email',
            'fields' => 'email,first_name,last_name,name'
        ],
        'Twitter' => [
            'key' => 'zOKTxAKJk4AhGjVRwrz2IAuCb',
			'secret' =>'' //シークレットを設定
        ]
    ]
];
