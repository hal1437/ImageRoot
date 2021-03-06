<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//テーブル使用

class DetailController extends AppController
{
	public function initialize(){
		parent::initialize();
		$this->viewBuilder()->layout('ImageRootHeader');
	}
	//モデルからこのrootのnodeを取得
	public function GetNodes(){
		TableRegistry::config("default");
		$model = TableRegistry::get('nodes');
		return $model->find('all',[
			'conditions' =>[
				'root_id' => $this->GetRootID()
			]
		])->order(['created' => 'ASC']);
	}
	public function GetRootID(){
		return $this->request->query['list'];
	}
	public function index(){
		$this->set('title','ImageRoot - Detail');

		//モデルからリストを抽出
		$this->set('list',$this->GetNodes());
	}
}


