<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//テーブル使用
use Cake\Cache\Cache;

class HomeController extends AppController
{
	public function initialize(){
		$this->viewBuilder()->layout('ToDoHeader');
	}
	public function index(){
		Cache::disable();
		$this->set('title','ImageRoot - TopPage');

		//モデルからリストを抽出
		$model = TableRegistry::get('roots');
		$this->set('query',$model->find());
	}

	public function all(){
		$this->autoRender = false;

		$model = TableRegistry::get('roots');
		$query = $model->find();
		foreach ($query as $row) {
			echo $row->getID();
			echo $row->getName();
		}
	}


}

