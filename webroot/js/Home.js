
//詳細画面

//作成押下時
function SubmitPushed(){
	var params = {
		title     : $("#ListName").val(),
		user_name : $("#NodeUser").val(), 
		message   : $("#NodeMessage").val(),
		image_id  : -1,
	};
	
	console.log(params);
	//添付画像があれば
	if ($("input[name='RootImage']").val()!== '') {
		var fd = new FormData();
		fd.append( "file", $("input[name='RootImage']").prop("files")[0] );

		//ファイルアップロード
		UploadImage(
			fd,
			function(image){
				//アップロードされた画像のURLを追加して作成
				params["image_id"] = JSON.parse(image)['image_id'];
				console.log(image);
				console.log(params);
				//成功時にNodeを作成する。
				CreateRoot(params);
			}
		);
	}else{
		//そのままNodeを作成
		CreateRoot(params);
	}
}


