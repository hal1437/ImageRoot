<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//テーブル使用

class DetailController extends AppController
{
	public function initialize(){
		$this->viewBuilder()->layout('ToDoHeader');
	}
	public function getList(){
		$model = TableRegistry::get('ToDoLists');
		$query = $model->find('all',[
			'conditions' =>[
				'list_id' => $this->request->query['list']
			]
		])->order(['made' => 'DESC']);
		foreach($query as $row){
			return $row;
		}
	}
	public function getListID(){
		return $this->getList()->getID();
	}
	public function index(){
		$this->set('title','ToDoLists - Detail');

		//モデルからリストを抽出
		$model = TableRegistry::get('ToDos');
		$list = $this->getList();
		$this->set('list'   ,$list);
		if($list != null){
			$this->set('query',$model->find('all',[
				'conditions' =>[
					'list_id' => $this->getListID()
				]
			])->order(['made' => 'DESC']));
		}
	}
}


