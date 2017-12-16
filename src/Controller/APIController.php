<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;//テーブル使用
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class APIController extends AppController
{

	//Rootをデータベースに登録
	private function create_root($request){
		//パラメータ取得
		$title     = h($request['title']);
		$user_name = h($request['user_name']);
		$image_id  = h($request['image_id']);
		$message   = h($request['message']);
		
		//各制限
		$roots = TableRegistry::get('roots');
		if($title    == ""          ){echo "タイトルが空です";return;}
		if($message  == ""          ){echo "本文が空です"    ;return ;}
		if($image_id == -1          ){echo "Rootの作成にはファイルの添付が必要です。"         ;return;}
		if(mb_strlen($title) >= 31  ){echo "Root名の最大文字数は30文字です。"                 ;return;}
		if($roots->existRoot($title)){echo "既に存在するRoot「". $title."」は作成できません。";return;}

		//新しいRootを作成
		$new_root = $roots->newEntity(); //エンティティ作成
		$new_root->title     = $title;
		$new_root->user_name = $user_name;
		$new_root->message   = $message;
		$new_root->image_id  = $image_id;
		$roots->save($new_root);
		return $new_root;
	}
	//Nodeをデータベースに登録
	private function create_node($request){
		//パラメータ取得
		$message   = h($request['message']);
		$user_name = h($request['user_name']);
		$root_id   = h($request['root_id']);
		$image_id  = h($request['image_id']);

		//各制限
		if($user_name == ""){echo "タイトルが空です";return ;}
		if($message   == ""){echo "本文が空です"    ;return ;}
		if($root_id   == ""){echo "root_idが空です" ;return ;}

		//新しいNode作成
		$nodes = TableRegistry::get('nodes');
		$new_node = $nodes->newEntity(); 
		$new_node->message   = $message;
		$new_node->user_name = $user_name;
		$new_node->root_id   = $root_id;
		$new_node->image_id  = $image_id;
		$nodes->save($new_node);
		return $new_node;
	}

	public function initialize(){
	}

	public function index(){
		$this->autoRender = false;
		echo $this->request->query('page');
	}
	//画像をS3サーバーとデータベースにアップロードし、image_idを返す
	public function UploadImage(){
		$this->autoRender = false;
		$s3client = S3Client::factory([
			'region' => 'us-east-2',
			'version' => 'latest',
		]);
		// 一時アップロード先ファイルパス
		$file_name = $this->request->data['file']["name"];
		$file_tmp  = $this->request->data['file']["tmp_name"];
		//S3にアップロード
		$result = $s3client->putObject([
			'Bucket'      => 'ir-s3-bucket',
			'Key'         => "Images/" . $file_name,
			'SourceFile'  => $file_tmp,
			'ContentType' => mime_content_type($file_tmp),
			'ACL'         => 'public-read',
		]);

		//新しいImageとしてデータベースにURLを登録
		$images = TableRegistry::get('images');
		$new_image = $images->newEntity(); //エンティティ作成
		$new_image->url = $result["ObjectURL"];
		$images->save($new_image);

		echo $new_image;
	}

	public function CreateRoot(){
		$this->autoRender = false;
		if($this->request->is('ajax')){
			$root = $this->create_root([
				"title"     => $this->request->getData('title'),
				"user_name" => $this->request->getData('user_name'),
				"message"   => $this->request->getData('message'),
				"image_id"  => $this->request->getData('image_id'),
			]);
			if($root == null)return;

			$node = $this->create_node([
				"message"   => $this->request->getData('message'),
				"user_name" => $this->request->getData('user_name'),
				"message"   => $this->request->getData('message'),
				"root_id"   => $root->root_id,
				"image_id"  => $this->request->getData('image_id'),
			]);
			if($node == null)return;
			
			echo "新しいRootを作成しました。";
		}else{
			echo "このAPIはajaxでのみ許可されます。";
		}
	}
	public function CreateNode(){
		$this->autoRender = false;
		$list = TableRegistry::get('nodes');
		if($this->request->is('ajax')){
			$node = $this->create_node([
				"message"   => $this->request->getData('message'),
				"user_name" => $this->request->getData('user_name'),
				"message"   => $this->request->getData('message'),
				"root_id"   => $this->request->getData('root_id'),
				"image_id"  => $this->request->getData('image_id'),
			]);
			if($node == null)return null;

			echo "新しいNodeを作成しました\n";
			echo $node->message;
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

