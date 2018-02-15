<?php
namespace App\Model\Table;
use Cake\ORM\Table;

class UsersTable extends Table {
	public function initialize(array $config){
		$this->table('users');
	}
	//ルートのIDでフィルター
	public function FilterTicket($ticket){
		return $this->find('all',[
			'conditions' => [
				'ticket' => $ticket
			]
		 ]);
	}
}


