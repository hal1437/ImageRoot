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
			//ファイルアップロード
		$s3client = S3Client::factory([
			'region' => 'us-east-2',
			'version' => 'latest',
		]);
		// 一時アップロード先ファイルパス
		$file_name = $this->request->data['file']["name"];
		$file_tmp  = $this->request->data['file']["tmp_name"];
		$result = $s3client->putObject([
			'Bucket'      => 'ir-s3-bucket',
			'Key'         => "Images/" . $file_name,
			'SourceFile'  => $file_tmp,
			'ContentType' => mime_content_type($file_tmp),
			'ACL'         => 'public-read',
		]);
		echo $result["ObjectURL"];
	}

	public function CreateRoot(){
		$this->autoRender = false;
		$roots = TableRegistry::get('roots');
		if($this->request->is('ajax')){
			$title     = h($this->request->getData('title'));
			$user_name = h($this->request->getData('user_name'));
			$image_id  = h($this->request->getData('image_id'));
			$message   = h($this->request->getData('message'));
			$image_url = h($this->request->getData('image_url'));

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
			if($roots->existRoot($title)){
				echo "既に存在するRoot「". $title."」は作成できません。";
				return;
			}
			if($image_url == ""){
				echo "画像URLが空です";
				return;
			}
			//新しいImage作成
			$images = TableRegistry::get('images');
			$new_image = $images->newEntity(); //エンティティ作成
			$new_image->url = $image_url;
			$images->save($new_image);

			//新しいRootを作成
			$new_root = $roots->newEntity(); //エンティティ作成
			$new_root->title     = $title;
			$new_root->user_name = $user_name;
			$new_root->message   = $message;
			$new_root->image_id  = $new_image->image_id;
			$roots->save($new_root);

			//新しいNode作成
			$nodes = TableRegistry::get('nodes');
			$new_node = $nodes->newEntity(); 
			$new_node->user_name = $user_name;
			$new_node->root_id   = $new_root->root_id;
			$new_node->message   = $message;
			$new_node->image_id  = $new_image->image_id;
			$nodes->save($new_node);
			
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

