function addTimestamps(e)
{
	/*Capturing client time. It may be a
	good idea if planning to synchronize 
	log data with other sources of data captured at the client side: e.g. video, eye tracking, etc. */
	var currentTime = new Date();
	var month = currentTime.getMonth() + 1; //getMonth retunrs values from 0 to 11.
	var day = currentTime.getDate();
	var year = currentTime.getFullYear();
	var clientDate = year + "/" + month + "/" + day;
	var hours = currentTime.getHours();
	var minutes = currentTime.getMinutes();
	var seconds = currentTime.getSeconds();
	var clientTime = hours + ":" + minutes + ":" + seconds;
	var clientTimestamp = currentTime.getTime();

	var form = $(e.currentTarget);
	console.log(form);

	form.append("<input type='hidden' name='clientTimestamp' value='" + clientTimestamp + "'/>");
	form.append("<input type='hidden' name='clientDate' value='" + clientDate + "'/>");
	form.append("<input type='hidden' name='clientTime' value='" + clientTime + "'/>");

	return true;
}
function init(){
	var forms = $("form.addTimestamps");
	forms.on("submit", addTimestamps);
	return false;
}
$(document).ready(function(){
	init();
});