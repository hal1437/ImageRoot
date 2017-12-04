
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

function CreateToDoList(){
	SendAjax(
		"/API/CreateToDoList",
		{ name : $("#ListName").val() },
		function(response){
			//通信成功時の処理
			alert(response);
			location.reload();
		}
	);
}

function CreateToDo(){
	var url   = location.href;
	params    = url.split("?");
	if(params.length < 2)return;
	spparams   = params[1].split("&")[0].split("=");
	SendAjax(
		"/API/CreateToDo",
		{
			text    : $("#ToDoText").val(), 
			todo_id : spparams[1],
			date    : $("#ToDoDate").val() 

		},
		function(response){
			//通信成功時の処理
			alert(response);
			location.reload();
		}
	);
}
function RemoveList(id){
	var con = confirm("このToDoListを削除しますか？");
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
function RemoveToDo(id){
	var con = confirm("このToDoを削除しますか？");
	if(con){
		SendAjax(
			"/API/RemoveToDo",
			{ id : id },
			function(response){
				//通信成功時の処理
				location.reload();
			}
		);	
	}
}
function ToggleToDo(index){
	SendAjax(
		"/API/ToggleCheck",
		{ id : index },
		function(response){
			location.reload();
		}
	);
}
