<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class NodesTable extends Table {
	public function initialize(array $config){
		$this->table('nodes');
	}
	//ルートのIDでフィルター
	public function FilterRootID($root_id){
		return $this->find('all',[
			'conditions' => [
				'root_id' => $root_id
			]
		 ]);
	}

}


