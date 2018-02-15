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
}


