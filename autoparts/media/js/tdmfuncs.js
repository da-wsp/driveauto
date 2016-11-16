function AddTips(track){
	$(function() {  $( document ).tooltip({track:true, content:function(){return $(this).prop('title');}});   });
}
function AddFSlyler(options){
	(function($) {  $(function(){ $(options).styler(); }) })(jQuery)
}
function TDMAddToCart(PHID){
	$("<form action='' id='addcartform' method='post'><input type='hidden' name='PHID' value='"+PHID+"'/></form>").appendTo('body');
	$("#addcartform").submit();
}
function TDMOrder(PKEY){
	$("<form action='' id='addcartform' method='post'><input type='hidden' name='TDORDER' value='"+PKEY+"'/></form>").appendTo('body');
	$("#addcartform").submit();
}
function AppWin(TDM_ROOT_DIR,ID,Width){
	var Left = (screen.width/2)-(Width/2);
	var Height = (screen.height-200);
	var newWin = window.open("/"+TDM_ROOT_DIR+"/apps.php?of="+ID, "JSSite",
	   "width="+Width+",height="+Height+",left="+Left+",top=40,resizable=yes,scrollbars=yes,status=no,menubar=no,toolbar=no,location=no,directories=no"
	);
	newWin.focus();
	$(newWin).blur(function() {
		newWin.close();
	});
}