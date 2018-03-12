<?php 
namespace App\Model\Entity;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;//テーブル使用

class Root extends Entity {
	public function GetRootID() {
		return $this->root_id;
	}
	public function GetTitle() {
		return $this->title;
	}
	public function GetImageURL() {
		$list = TableRegistry::get('images');
		$query = $list->find('all',[
			'conditions' =>[
				'image_id' => $this->image_id
			]
		]);
		if($query->count() > 0)return $query->first()->GetURL();
		else return "";
	}
	public function GetNodeIndex($node_id){
		$nodes = TableRegistry::get('nodes');
		$query = $nodes->find('all',[
			'conditions' =>[
				'root_id' => $this->GetRootID()
			]
		]);
		foreach($query as $index => $value){
			if($value->GetNodeID() == $node_id)return $index;
		}
		return -1;
	}
}

