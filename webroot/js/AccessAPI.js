
function UploadImage(){
	// フォームデータを取得
	var formdata = new FormData($('#NodeImage').get(0));

	// POSTでアップロード
	$.ajax({
		url  : "/API/UploadImage",
		type : "POST",
		data : formdata,
		cache       : false,
		contentType : false,
		processData : false,
		dataType    : "html"
	})
	.done(function(data, textStatus, jqXHR){
		console.log(data);
	})
	.fail(function(jqXHR, textStatus, errorThrown){
		alert("fail");
	});
}

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

function CreateRoot(){
	SendAjax(
		"/API/CreateRoot",
		{title     : $("#ListName").val(),
		 user_name : $("#NodeUser").val(), 
		 message   : $("#NodeMessage").val(),
		 image_id  : -1},
		 function(response){
// 			location.href = "/detail?list=" + response;
			alert(response);
			location.reload();
		}
	);
}

function CreateNode(){
	var url   = location.href;
	params    = url.split("?");
	if(params.length < 2)return;
	spparams   = params[1].split("&")[0].split("=");
	SendAjax(
		"/API/CreateNode",
		{
			user_name : $("#NodeUser").val(), 
			message   : $("#NodeMessage").val(),
			root_id   : spparams[1]
		},
		function(response){
			//通信成功時の処理
			alert(response);
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
