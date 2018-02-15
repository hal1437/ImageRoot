<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//テーブル使用

class UsersController extends AppController
{
	public function initialize(){
		parent::initialize();
		$this->viewBuilder()->layout('ImageRootHeader');
	}
	public function login(){
		$this->set('title','ImageRoot - Login');
	}
}

