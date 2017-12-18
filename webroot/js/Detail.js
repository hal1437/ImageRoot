
//詳細画面
$(".loading-gif").hide();

//作成押下時
function SubmitPushed(){
	$(".loading-gif").show();
	var url_params = location.href.split("?");
	if(url_params.length < 2)return;//クエリに不具合あり

	var params = {
		user_name : $("#NodeUser").val(), 
		message   : $("#NodeMessage").val(),
		root_id   : url_params[1].split("&")[0].split("=")[1],
		image_id  : -1,
	};
	
	//添付画像があれば
	if ($("input[name='NodeImage']").val()!== '') {
		var fd = new FormData();
		fd.append( "file", $("input[name='NodeImage']").prop("files")[0] );

		$(".status-message").text("ファイルアップロード中");
		//ファイルアップロード
		UploadImage(
			fd,
			function(image){
				//アップロードされた画像のURLを追加して作成
				params["image_id"] = JSON.parse(image)['image_id'];
				$(".status-message").text("Node作成中");
				//成功時にNodeを作成する。
				CreateNode(params);
			}
		);
	}else{
		$(".status-message").text("Root作成中");
		//そのままNodeを作成
		CreateNode(params);
	}
}

