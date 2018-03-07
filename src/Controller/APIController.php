<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;//テーブル使用
use Cake\Core\Configure;
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

class APIController extends AppController
{

	//Rootをデータベースに登録
	private function create_root($request){
		TableRegistry::config("write");
		//パラメータ取得
		$title     = h($request['title']);
		$user_name = h($request['user_name']);
		$image_id  = h($request['image_id']);
		$message   = h($request['message']);
		
		//各制限
		$roots = TableRegistry::get('roots');
		if($title     == ""          ){echo "タイトルが空です";return;}
		if($user_name == ""          ){echo "チケットが不正です";return ;}
		if($message   == ""          ){echo "本文が空です"    ;return ;}
		if($image_id  == -1          ){echo "Rootの作成にはファイルの添付が必要です。"         ;return;}
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
		TableRegistry::config("write");
		//パラメータ取得
		$message   = h($request['message']);
		$user_name = h($request['user_name']);
		$root_id   = h($request['root_id']);
		$image_id  = h($request['image_id']);

		//各制限
		if($user_name == ""){$this->response->body("チケットが不正です");return ;}
		if($message   == ""){$this->response->body("本文が空です"    );return ;}
		if($root_id   == ""){$this->response->body("root_idが空です" );return ;}

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
	private function getUsernameFromTicket($ticket){
		$users = TableRegistry::get('users');
		foreach($users->FilterTicket($ticket) as $index => $row){
			return $row->username;
		}
		return "";
	}

	public function initialize(){
	}

	public function index(){
		$this->autoRender = false;
		//echo $this->request->query('page');
	}
/*
	private function GetNearImages(){
		TableRegistry::config("write");
		$this->autoRender = false;
		if($this->request->is('ajax')){

			$urls = array();
			$heuristics = array();
			$comp_url = $this->request->getData('comp_url')

			//全ての画像のURLを取得
			$list = TableRegistry::get('images');
			$query = $list->find();
			foreach($query as $row){
				$urls[] = $row->GetURL();
			}
			
			//評価
			$pic1 = puzzle_fill_cvec_from_file($comp_url);
			foreach($urls as $url){
				//近似度判定
				$pi2 = puzzle_fill_cvec_from_file($url);
				$d = puzzle_vector_normalized_distance($pic1, $pic2);
				$heuristics[$d] = $url;
			}
			//評価が高い順にソート
			usort($heuristics);
			echo json_encode($heuristics);
		}else{
			echo "このAPIはajaxでのみ許可されます。";
		}
	}
 */
	//画像をS3サーバーとデータベースにアップロードし、image_idを返す
// 	public function GetNearImages(){
// 	}
	//画像をS3サーバーとデータベースにアップロードし、image_idを返す
	public function UploadImage(){
		TableRegistry::config("write");
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

		//CloudFrontが登録されていなければそのままS3のリンクを設定
		$image_url = "";
		if(Configure::read('cloud_front_domain', 'CloudFront.php') == ""){
			$image_url = $result["ObjectURL"];
		}else{
			$image_url = "http://".Configure::read('cloud_front_domain', 'CloudFront.php')."/Images/".$file_name;
		}

		//新しいImageとしてデータベースにURLを登録
		$images = TableRegistry::get('images');
		$new_image = $images->newEntity(); //エンティティ作成
		$new_image->url = $image_url;
		$images->save($new_image);

		$this->response->body($new_image);

	}

	public function CreateRoot(){
		TableRegistry::config("write");
		$this->autoRender = false;
		if($this->request->is('ajax')){
			$root = $this->create_root([
				"title"     => $this->request->getData('title'),
				"user_name" => $this->getUsernameFromTicket($this->request->getData('ticket')),
				"message"   => $this->request->getData('message'),
				"image_id"  => $this->request->getData('image_id'),
			]);
			if($root == null)return;

			$node = $this->create_node([
				"message"   => $this->request->getData('message'),
				"user_name" => $this->getUsernameFromTicket($this->request->getData('ticket')),
				"message"   => $this->request->getData('message'),
				"root_id"   => $root->root_id,
				"image_id"  => $this->request->getData('image_id'),
			]);
			if($node == null)return;
			
			$this->response->body("新しいRootを作成しました\n");

		}else{
			echo "このAPIはajaxでのみ許可されます。";
		}
	}
	public function CreateNode(){
		TableRegistry::config("write");
		$this->autoRender = false;
		$list = TableRegistry::get('nodes');
		if($this->request->is('ajax')){
			$node = $this->create_node([
				"message"   => $this->request->getData('message'),
				"user_name" => $this->getUsernameFromTicket($this->request->getData('ticket')),
				"message"   => $this->request->getData('message'),
				"root_id"   => $this->request->getData('root_id'),
				"image_id"  => $this->request->getData('image_id'),
			]);
			if($node == null)return null;

			$this->response->body("新しいNodeを作成しました\n");

		}else{
			echo "このAPIはajaxでのみ許可されます。";
		}
	}
	public function RemoveRoot(){
		TableRegistry::config("write");
		$this->autoRender = false;
		$list = TableRegistry::get('roots');
		$obj = $list->get(h($this->request->getData('root_id')));
		$list->delete($obj);
		echo "削除";
	}
	public function RemoveNode(){
		TableRegistry::config("write");
		$this->autoRender = false;
		$list = TableRegistry::get('nodes');
		$obj = $list->get(h($this->request->getData('node_id')));
		$list->delete($obj);
		echo "削除";
	}

}

