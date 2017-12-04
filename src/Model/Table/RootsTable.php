<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class RootsTable extends Table {
	public function initialize(array $config){
		$this->table('roots');
	}
	//リストの存在確認
	public function existToDoList($name){
		return $this->find('all',[
			'conditions' => [
				'name' => $name
			]
		 ])->count() > 0;
	}
}

