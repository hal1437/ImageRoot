
window.onload = function() {
	//クッキーに名前が存在するか確認
	if($.cookie('username') != undefined){
		$('#NodeUser').attr("value",$.cookie('username'));
		$('#NodeUser').prop("disabled", true);
	}
};
