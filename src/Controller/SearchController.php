<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//テーブル使用

class SearchController extends AppController
{
	public function initialize(){
		$this->viewBuilder()->layout('ToDoHeader');
	}
	public function index(){
		$this->set('title','ToDoLists - Search');

		$key_word = h($this->request->query('word'));
		$this->set('key_word',$key_word);
		if($key_word==''){
			$key_word = "レポート";
		}
		$this->Search($key_word);
	}

	//検索
	public function Search($key_word){
		$lists = TableRegistry::get('ToDoLists');
		$todos = TableRegistry::get('ToDos');
		
		//リストの検索
		$list_query = $lists->find('all',[
			'conditions' => [
				'name LIKE' => '%'.$key_word.'%'
			]
		])->order(['made' => 'DESC']);
		//todoの検索
		$todo_query = $todos->find('all',[
			'conditions' => [
				'text LIKE' => '%'.$key_word.'%'
			]
		])->order(['made' => 'DESC']);
		$this->set('list_query',$list_query);
		$this->set('todo_query',$todo_query);
	}
}


