<?php 
namespace App\Model\Entity;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;//テーブル使用

class Image extends Entity {
	public function GetImageID() {
		return $this->image_id;
	}
	public function GetURL() {
		return $this->url;
	}
}

