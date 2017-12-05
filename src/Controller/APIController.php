<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;//テーブル使用

class APIController extends AppController
{
	public function initialize(){
	}
	public function index(){
		$this->autoRender = false;
		echo $this->request->query('page');
	}
	public function createRoot(){
		$this->autoRender = false;
		$list = TableRegistry::get('root');
		if($this->request->is('ajax')){
			$new_name = h($this->request->getData('name'));
			if($new_name == ""){
				echo "リスト名が空です";
				return ;
			}
			if(mb_strlen($new_name)>=31){
				echo "Root名の最大文字数は30文字です。";
				return;
			}

			//重複
			if($list->existRoot($new_name)){
				echo "既に存在するRoot「". $new_name."」は作成できません。";
				return;
			}
			$entity = $list->newEntity(); //エンティティ作成
			$entity->setName($new_name);
			$list->save($entity);
			echo "新しいRoot「".$entity->name."」を作成しました";   //echoでもOK
		}else{
			echo "このAPIはajaxでのみ許可されます。";
		}
	}
	public function createNode(){
		$this->autoRender = false;
		$list = TableRegistry::get('nodes');
		if($this->request->is('ajax')){
			//Node内容が空
			if(h($this->request->getData('message')) == ""){
				echo "Node内容が空です。";
				return;
			}
// 			if(mb_strlen(h($this->request->getData('text')))>=31){
// 				echo "Node名の最大文字数は30文字です。";
// 				return;
// 			}
			//エンティティ追加
			$entity = $list->newEntity(); 
			$entity->user_name = h($this->request->getData('user_name'));
			$entity->root_id   = h($this->request->getData('root_id'));
			$entity->message   = h($this->request->getData('message'));
			$entity->image_id  = -1;
			echo "新しいNodeを作成しました\n";   //echoでもOK
			echo $this->request->getData('message');   //echoでもOK
		}else{
			echo "このAPIはajaxでのみ許可されます。";
		}
	}
	public function RemoveRoot(){
		$this->autoRender = false;
		$list = TableRegistry::get('roots');
		$obj = $list->get(h($this->request->getData('root_id')));
		$list->delete($obj);
		echo "削除";
	}
	public function RemoveNode(){
		$this->autoRender = false;
		$list = TableRegistry::get('nodes');
		$obj = $list->get(h($this->request->getData('node_id')));
		$list->delete($obj);
		echo "削除";
	}

}

