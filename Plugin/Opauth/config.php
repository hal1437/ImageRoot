
<?php
// 各プロバイダ毎のAPIキー
$config = [
	'security_salt' => '2sBz1U5epdrtub6DQH26MfzhXAehaf1H55SRwTBu',
	'path' => '/auth/',
    'callback_url' => '/auth/complete', 
    'Strategy' => [
        'Facebook' => [
            'app_id' => '',//アプリキー設定
            'app_secret' => '', //シークレットを設定
            'scope' => 'email',
            'fields' => 'email,first_name,last_name,name'
        ],
        'Twitter' => [
            'key' => '', //コンシューマーキー設定
	    	'secret' =>'' //シークレットを設定
        ]
    ]
];
