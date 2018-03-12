<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class ImagesTable extends Table {
	public function initialize(array $config){
		$this->table('images');
	}
	public function GetFromID($image_id){
		return $this->find('all',[
			'conditions' =>[
				'image_id' => $image_id
			]
		])->first();
	}
}



