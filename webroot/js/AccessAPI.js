
function SendAjax(url,data,success){
	$.ajax({
		url: url,
		type: "POST",
		data: data,
		dataType: "text",
		success : success,
		error: function(data){
			//通信失敗時の処理
			alert('通信失敗');
			console.log(data);
		}
	});
}

function UploadImage(data,success){
	$.ajax({
		url     : "API/UploadImage",
		type    : "POST",
		data    : data,
		success : success,
		error: function(data){
			//通信失敗時の処理
			alert('通信失敗');
			console.log(data);
		},
		processData : false,
		contentType : false
	});
}

function CreateRoot(){

	var fd = new FormData();
	if ($("input[name='Image']").val()!== '') {
		fd.append( "file", $("input[name='Image']").prop("files")[0] );
	}
	fd.append("dir",$("#Image").val());

	//画像のアップロード
	UploadImage(
		fd,
		function(image_url){
			//Root作成
			SendAjax(
				"/API/CreateRoot",
				{title     : $("#ListName").val(),
				user_name : $("#NodeUser").val(), 
				message   : $("#NodeMessage").val(),
				image_url : image_url,
				},
				function(response){
					console.log(response);
					location.reload();
				}
			);
		}
	);

	}

function CreateNode(){
	// フォームデータを取得
	var formdata = new FormData();
	formdata.append("NodeImage",$('#NodeImage').get(0));

	var url   = location.href;
	params    = url.split("?");
	if(params.length < 2)return;
	spparams   = params[1].split("&")[0].split("=");
	SendAjax(
		"/API/CreateNode",
		{
			user_name : $("#NodeUser").val(), 
			message   : $("#NodeMessage").val(),
			root_id   : spparams[1],
			data      : formdata,
		},
		function(response){
			//通信成功時の処理
			console.log(response);
			location.reload();
		}
	);
}
function RemoveRoot(id){
	var con = confirm("このRootを削除しますか？");
	if(con){
		SendAjax(
			"/API/RemoveList",
			{ id : id },
			function(response){
				//通信成功時の処理
				location.href = "/home";
			}
		);	
	}
}
function RemoveNode(id){
	var con = confirm("このNodeを削除しますか？");
	if(con){
		SendAjax(
			"/API/RemoveNode",
			{ id : id },
			function(response){
				//通信成功時の処理
				location.reload();
			}
		);	
	}
}
