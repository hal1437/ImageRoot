<?php 
namespace App\Model\Entity;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;//テーブル使用
use \Datetime;
use \DatetimeZone;

class Node extends Entity {
	public function GetNodeID() {
		return $this->node_id;
	}
	public function GetRootID() {
		return $this->root_id;
	}
	public function GetCreated() {
		$date = new DateTime('@' . strtotime($this->created));
		$date->setTimeZone( new DateTimeZone('Asia/Tokyo'));
		return $date->format("Y年m月d日 H時i分");
	}
	public function GetUserName() {
		return $this->user_name;
	}
	public function GetMessage() {
		return $this->message;
	}
	public function GetReplyID() {
		return $this->reply_id;
	}
	public function GetImageID() {
		return $this->image_id;
	}
	public function GetReplyNode() {
		if($this->node_id == -1)return null;
		else{
			$list = TableRegistry::get('nodes');
			$query = $list->find('all',[
				'conditions' =>[
					'node_id' => $this->reply_id
				]
			]);
			return $query->first();
		}
	}
	public function GetImageURL() {
		if($this->image_id == -1)return null;
		else{
			$list = TableRegistry::get('images');
			return $list->GetFromID($this->image_id)["url"];
		}
	}
}


