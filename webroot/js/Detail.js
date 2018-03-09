
//詳細画面
$(".loading-gif").hide();

//作成押下時
function SubmitPushed(){
	$(".loading-gif").show();
	var url_params = location.href.split("?");
	if(url_params.length < 2)return;//クエリに不具合あり

	var params = {
		ticket    : $.cookie("ticket"), 
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


//モーダル展開時のイベント
for(var i=1;i <= document.getElementsByClassName("node-message").length;i++){
	$('#image_Modal' + i).on('show.bs.modal',{ index : i }, function (e) {

		console.log(e.data.index + "番目の画像詳細が展開されました。");
		SendAjax("/API/GetNearImages",
			{
				comp_url: document.getElementById("image"+e.data.index).src
			},	
			function(response){
				//通信成功時の処理
				alert(response);
				location.reload();
			}
		);
	})
}



