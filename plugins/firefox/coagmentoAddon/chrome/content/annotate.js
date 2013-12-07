pref("dom.allow_scripts_to_close_windows", true);
function onSave(){
	var content = $("#annotation_content").val();
	window.opener.saveAnnotation(content);
	window.close();
}