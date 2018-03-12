
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
			$(".loading-gif").hide();
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
			alert('画像のアップロードに失敗しました');
			console.log(data);
		},
		processData : false,
		contentType : false
	});
}

function CreateRoot(params){
	SendAjax(
		"/API/CreateRoot",
		params,
		function(response){
			//通信成功時の処理
			alert(response);
			location.reload();
		}
	);
}

function CreateNode(params){
	SendAjax(
		"/API/CreateNode",
		params,
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
