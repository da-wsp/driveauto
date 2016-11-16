function DelConfirm(Yes,No,Title,DelElem){
	var btns = {};
	btns[Yes] = function(){ 
		$("<form action='' id='deleteform' method='post'><input type='hidden' name='delete' value='Y'/><input type='hidden' name='delem' id='DElement' value='"+DelElem+"'/></form>").appendTo('body');
		$(this).dialog("close");
		$("#deleteform").submit();
	};
	btns[No] = function(){
		$(this).dialog("close");
	};
	$("<div></div>")
	.appendTo('body')
	.html(Title)
	.dialog({
		autoOpen: true,
		modal:true,
		buttons:btns
	});
	$(".ui-dialog-titlebar").hide();
}

