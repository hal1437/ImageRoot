<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;//テーブル使用

// ソーシャルログイン用コントローラー
class AuthController extends AppController
{

	private function generateRandomStr($length) {
		$str = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'));
		$r_str = null;
		for ($i = 0; $i < $length; $i++) {
			$r_str .= $str[rand(0, count($str) - 1)];
		}
		return $r_str;
	}


	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		// レイアウトなし
		$this->autoRender = FALSE;
	}

	// /auth/facebook
	public function facebook()
	{
		$this->authFunction();
	}

	// /auth/twitter
	public function twitter()
	{
		$this->authFunction();
	}

	// 共通function
	private function authFunction()
	{
		// Opauth require_once
		$opauth_path = './Plugin/Opauth/';
		require_once $opauth_path.'config.php';
		require_once $opauth_path.'Opauth.php';

		// ソーシャルログイン処理
		new \Opauth($config);
	}

	// ソーシャルログイン完了後のaction
	public function complete()
	{
		// session.auto_startオンやAuthなどでセッションスタート済みの場合不要
		if (!isset($_SESSION['opauth'])) {
			session_start();
		}

		// 取得データ表示
		if (isset($_SESSION['opauth']['auth'])) {
			// 成功
			// CakePHP ~3.4
			$session = $this->request->session();
			$session->write('opauth', $_SESSION['opauth']['auth']);

			//名前取り出し
			$username =  $session->read('opauth')['info']['name'];

			//データベースに保存
			$users = TableRegistry::get('users');
			$new_user = $users->newEntity(); 
			$new_user->ticket   = $this->generateRandomStr(255);
			$new_user->username = $username;
			$users->save($new_user);

			//クッキーにチケットを保存
			$this->Cookie->configKey('ticket'  , 'encryption', false);
			$this->Cookie->configKey('username', 'encryption', false);
			$this->Cookie->write('ticket', $new_user->ticket);
			$this->Cookie->write('username', $username);
			//移動
			return $this->redirect(
				['controller' => 'Home', 'action' => 'index']
			);

		} elseif (isset($_SESSION['opauth']['error'])) {
			// 失敗
			var_dump($_SESSION['opauth']['error']);
		} else {
			// その他失敗
			echo 'Opauth ERROR!';
		}
	}
}
