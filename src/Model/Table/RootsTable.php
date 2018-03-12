<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class RootsTable extends Table {
	public function initialize(array $config){
		$this->table('roots');
	}
	//リストの存在確認
	public function existRoot($name){
		return $this->find('all',[
			'conditions' => [
				'title' => $name
			]
		 ])->count() > 0;
	}
	public function GetFromID($root_id){
		return $this->find('all',[
			'conditions' =>[
				'root_id' => $root_id
			]
		])->first();
	}
}

