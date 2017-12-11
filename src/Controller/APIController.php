<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;//テーブル使用
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class APIController extends AppController
{
	public function initialize(){
	}
	public function index(){
		$this->autoRender = false;
		echo $this->request->query('page');
	}
	public function UploadImage(){
		$this->autoRender = false;

		// 一時アップロード先ファイルパス
		$file_tmp  = $_FILES["NodeImage"]["tmp_name"];
		$s3client = S3Client::factory([
			'region' => 'us-east-2',
			'version' => 'latest',
		]);
		$result = $s3client->putObject([
			'Bucket' => 'ir-s3-bucket',
			'Key' => "Images/".$_FILES["NodeImage"]["name"],
			'SourceFile' => $file_tmp,
			'ContentType' => mime_content_type($file_tmp),
		]);

		echo $result;
	}
	public function CreateRoot(){
		$this->autoRender = false;
		$list = TableRegistry::get('roots');
		if($this->request->is('ajax')){
			$title     = h($this->request->getData('title'));
			$user_name = h($this->request->getData('user_name'));
			$image_id  = h($this->request->getData('image_id'));
			$message   = h($this->request->getData('message'));
			//空文字
			if($title == ""){
				echo "タイトルが空です";
				return ;
			}
			//空文字
			if($message == ""){
				echo "本文が空です";
				return ;
			}
			//最大文字数
			if(mb_strlen($title)>=31){
				echo "Root名の最大文字数は30文字です。";
				return;
			}
			//重複
			if($list->existRoot($title)){
				echo "既に存在するRoot「". $title."」は作成できません。";
				return;
			}

			$entity = $list->newEntity(); //エンティティ作成
			$entity->title     = $title;
			$entity->user_name = $user_name;
			$entity->message   = $message;
			$entity->image_id  = $image_id;
			$list->save($entity);

			//Node作成
			$nodes = TableRegistry::get('nodes');
			$node = $nodes->newEntity(); 
			$node->user_name = $user_name;
			$node->root_id   = $entity->root_id;
			$node->message   = $message;
			$node->image_id  = $image_id;
			$nodes->save($node);
			
			echo "新しいRootを作成しました。";
		}else{
			echo "このAPIはajaxでのみ許可されます。";
		}
	}
	public function CreateNode(){
		$this->autoRender = false;
		$list = TableRegistry::get('nodes');
		if($this->request->is('ajax')){
			//Node内容が空
			if(h($this->request->getData('message')) == ""){
				echo "Node内容が空です。";
				return;
			}
// 			if(mb_strlen(h($this->request->getData('text')))>=31){
// 				echo "Node名の最大文字数は30文字です。";
// 				return;
// 			}
			//エンティティ追加
			$entity = $list->newEntity(); 
			$entity->user_name = h($this->request->getData('user_name'));
			$entity->root_id   = h($this->request->getData('root_id'));
			$entity->message   = h($this->request->getData('message'));
			$entity->image_id  = -1;
			$list->save($entity);
			echo "新しいNodeを作成しました\n";   //echoでもOK
			echo $this->request->getData('message');   //echoでもOK
		}else{
			echo "このAPIはajaxでのみ許可されます。";
		}
	}
	public function RemoveRoot(){
		$this->autoRender = false;
		$list = TableRegistry::get('roots');
		$obj = $list->get(h($this->request->getData('root_id')));
		$list->delete($obj);
		echo "削除";
	}
	public function RemoveNode(){
		$this->autoRender = false;
		$list = TableRegistry::get('nodes');
		$obj = $list->get(h($this->request->getData('node_id')));
		$list->delete($obj);
		echo "削除";
	}

}

