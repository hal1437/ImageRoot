
document.addEventListener( 'DOMContentLoaded', function()
{
	//クッキーに名前が存在するか確認
	if($.cookie('username')!=undefined){
		$(".navbar-right").toggleClass("hidden");
		$("#UsernameButton").text($.cookie('username') + " ");
	}
}, false );
function ClearUsername(){
	$.removeCookie("username");
	location.reload();
}


