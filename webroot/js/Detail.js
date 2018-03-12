
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
				console.log(image);
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
		SendAjax("/API/GetNearNodes",
			{
				comp_url: document.getElementById("image" + e.data.index).src,
				index   : e.data.index
			},	
			function(response){
				//通信成功時の処理
				var perse = JSON.parse(response)
				var index = perse['index'];
			
				//似ているNodeを追記
				var list = document.getElementById("image_Modal"+index).getElementsByClassName("near-contents")[0];
				if(list.childElementCount < 3){
					for(key in perse){
						if(key=="index")continue;
						var div = document.createElement("div");
						var a   = document.createElement("a");
						var p   = document.createElement("p");
						var img = document.createElement("img");
						div.classList.add("col-xs-6","col-md-6");
						a.classList.add("thumbnail");
						a.href = "/detail?list=" + perse[key].root_id + "#Node"+perse[key].node_id;
						p.innerHTML = 
							"Root名　：" + perse[key].root_name  + "<br>" + 
							"Node番号：" + perse[key].node_index + "<br>" + 
							"Node文章：" + perse[key].message    + "<br>" + 
							"距離　　：" + key*0.00001           + "<br>";
						img.src = perse[key].image_url;

						list.appendChild(div);
						div.appendChild(a);
						a.appendChild(img);
						a.appendChild(p);
					}
					//ロード画面を隠す
					$("#image_modal_loading"+index).hide();
				}
			}
		);
	})
}



