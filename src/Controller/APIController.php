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
	public function createToDoList(){
		$this->autoRender = false;
		$list = TableRegistry::get('ToDoLists');
		if($this->request->is('ajax')){
			$new_name = h($this->request->getData('name'));
			if($new_name == ""){
				echo "リスト名が空です";
				return ;
			}
			if(mb_strlen($new_name)>=31){
				echo "ToDo名の最大文字数は30文字です。";
				return;
			}

			//重複
			if($list->existToDoList($new_name)){
				echo "既に存在するToDoList「". $new_name."」は作成できません。";
				return;
			}
			$entity = $list->newEntity(); //エンティティ作成
			$entity->setName($new_name);
			$list->save($entity);
			echo "新しいToDoList「".$entity->name."」を作成しました";   //echoでもOK
		}else{
			echo "このAPIはajaxでのみ許可されます。";
		}
	}
	public function createToDo(){
		$this->autoRender = false;
		$list = TableRegistry::get('ToDos');
		if($this->request->is('ajax')){
			//ToDo名が空
			if(h($this->request->getData('text')) == ""){
				echo "ToDo名が空です。";
				return;
			}
			if(mb_strlen(h($this->request->getData('text')))>=31){
				echo "ToDo名の最大文字数は30文字です。";
				return;
			}
			//重複
			if($list->existToDo($this->request->getData('todo_id'),h($this->request->getData('text')))){
				echo "既に存在するToDo「". h($this->request->getData('text'))."」は作成できません。";
				return;
			}
			//日付フォーマットチェック
			$datetime = h($this->request->getData('date'));
			if($datetime == ""){
				echo "締め切り日が選択されていません。";
				return;
			}
			//エンティティ追加
			$entity = $list->newEntity(); 
			$entity->list_id = h($this->request->getData('todo_id'));
			$entity->text    = h($this->request->getData('text'));
			$entity->lim     = $datetime;
			$entity->comp    = false;
			$list->save($entity);
			echo "新しいToDo「".$entity->text."」を作成しました。";
			echo "期限は".$entity->getLimit()."までです。";
		}else{
			echo "このAPIはajaxでのみ許可されます。";
		}
	}
	public function RemoveList(){
		$this->autoRender = false;
		$list = TableRegistry::get('ToDoLists');
		$obj = $list->get(h($this->request->getData('id')));
		$list->delete($obj);
		echo "削除";
	}
	public function RemoveToDo(){
		$this->autoRender = false;
		$list = TableRegistry::get('ToDos');
		$obj = $list->get(h($this->request->getData('id')));
		$list->delete($obj);
		echo "削除";
	}
	public function ToggleCheck(){
		$this->autoRender = false;
		if($this->request->is('ajax')){
			$id = $this->request->getData('id');
			$todos = TableRegistry::get('ToDos');
			$obj = $todos->get($id);

			$obj->comp = !$obj->comp;//反転
			$todos->save($obj);
			echo "反転";
		}else{
			echo "このAPIはajaxでのみ許可されます。";
		}
	}

}

