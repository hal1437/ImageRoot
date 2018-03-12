<?php
namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;//テーブル使用

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
	public function GetNodeFromImageURL($image_url){
		$images = TableRegistry::get('images');
		$image_id = $images->find('all',[
			'conditions' =>[
				'url' => $image_url
			]
		])->first()->GetImageID();
		return $this->find('all',[
			'conditions' =>[
				'image_id' => $image_id
			]
		])->first();
	}
	public function GetFromID($node_id){
		return $this->find('all',[
			'conditions' =>[
				'node_id' => $node_id
			]
		])->first();
	}
}


