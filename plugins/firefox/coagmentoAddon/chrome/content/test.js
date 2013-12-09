var id = 1;
function login(){
	alert(id);
	id = 10;
	//dw window.addEventListener("load", function(){alert("1");});
	//dw gBrowser.addEventListener("load", function(){alert("5");});
	//alert("2");

	gBrowser.addProgressListener({
		onLocationChange: function(aProgress, aRequest, aURI) {
	      //this works
	      alert(id);
	    },

	    onStateChange: function() {
	    },
	    onProgressChange: function() {},
	    onStatusChange: function() {},
	    onSecurityChange: function() {}
	});
}