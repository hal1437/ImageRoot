
//詳細画面

$(".loading-gif").hide();

//作成押下時
function SubmitPushed(){
	$(".loading-gif").show();
	var params = {
		title     : $("#ListName").val(),
		ticket    : $.cookie("ticket"), 
		message   : $("#NodeMessage").val(),
		image_id  : -1,
	};
	
	//添付画像があれば
	if ($("input[name='RootImage']").val()!== '') {
		var fd = new FormData();
		fd.append( "file", $("input[name='RootImage']").prop("files")[0] );

		$(".status-message").text("ファイルアップロード中");
		//ファイルアップロード
		UploadImage(
			fd,
			function(image){
				console.log(image);
				//アップロードされた画像のURLを追加して作成
				params["image_id"] = JSON.parse(image)['image_id'];
				$(".status-message").text("Root作成中");
				//成功時にNodeを作成する。
				CreateRoot(params);
			}
		);
	}else{
		$(".status-message").text("Root作成中");
		//そのままNodeを作成
		CreateRoot(params);
	}
}


