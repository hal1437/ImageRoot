
//詳細画面

//作成押下時
function SubmitPushed(){
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

		//ファイルアップロード
		UploadImage(
			fd,
			function(image){
				//アップロードされた画像のURLを追加して作成
				params["image_id"] = JSON.parse(image)['image_id'];
				//成功時にNodeを作成する。
				CreateNode(params);
			}
		);
	}else{
		//そのままNodeを作成
		CreateNode(params);
	}
}

