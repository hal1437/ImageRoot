
document.addEventListener( 'DOMContentLoaded', function()
{
	//クッキーに名前が存在するか確認
	if($.cookie('ticket')!=undefined){
		$(".navbar-right").toggleClass("hidden");
		$("#UsernameButton").text($.cookie('username') + " ");
	}
}, false );

function Logout(){
	$.removeCookie("ticket");
	location.reload();
}


