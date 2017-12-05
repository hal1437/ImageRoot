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
	public function CreateRoot(){
		$this->autoRender = false;
		$list = TableRegistry::get('roots');
		if($this->request->is('ajax')){
			$title = h($this->request->getData('title'));
			if($title == ""){
				echo "タイトルが空です";
				return ;
			}
			if(mb_strlen($title)>=31){
				echo "Root名の最大文字数は30文字です。";
				return;
			}

			//重複
			if($list->existRoot($title)){
				echo "既に存在するRoot「". $title."」は作成できません。";
				return;
			}
			$entity = $list->newEntity(); //エンティティ作成
			$entity->title    = h($this->request->getData('title'));
			$entity->image_id = h($this->request->getData('image_id'));
			$list->save($entity);
// 			echo "新しいRoot「".$entity->name."」を作成しました";   //echoでもOK
		}else{
			echo "このAPIはajaxでのみ許可されます。";
		}
	}
	public function CreateNode(){
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

