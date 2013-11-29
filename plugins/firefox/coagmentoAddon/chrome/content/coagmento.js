// Coagmento Firefox extension
// Beta 3.0.6
// Author: Chirag Shah and Roberto Gonzalez-Ibanez
// Last update: May 10, 2011

// Toolbar related functions

// Add a listener to the current window.
var rootURL = "http://localhost/coagmentoCollaboratory/plugins/pages/";

window.addEventListener("load", function() { coagmentoToolbar.init(); }, false);

//Return version
function getVersion()
{
   return '308';
}

// WHEN THE USER SWITCH TAB
function tabSelected(event) {
    if (isVersionCorrect)
    {
        savePQ();
        checkCurrentPage();
    }
}

// Constructor for the toolbar.
var coagmentoToolbar =  {
    target:document.getElementsByTagName('TITLE')[0],
    oldValue:document.title,

  // WHEN FIREFOX RUN FOR FIRST TIME
    //This is for capturing events like those that take place on google instant.
    onChange: function()
                  {
                    if(coagmentoToolbar.oldValue!==document.title)
                    {
                      coagmentoToolbar.oldValue=document.title;
                      //alert('somebody changed the title');
                        savePQ();
                        //checkCurrentPage();
                    }
                 },

    delay:function()
                {
                  setTimeout(coagmentoToolbar.onChange,1);
                },
                

  init: function() {
       var container = gBrowser.tabContainer;
	container.addEventListener("TabSelect", tabSelected, false);
        container.addEventListener('DOMSubtreeModified',coagmentoToolbar.delay,false)
        var appcontent = document.getElementById("appcontent");   // browser
        if(appcontent)
          appcontent.addEventListener("DOMContentLoaded", coagmentoToolbar.onPageLoad, true);
        var messagepane = document.getElementById("messagepane"); // mail
        if(messagepane)
            messagepane.addEventListener("load", function () { coagmentoToolbar.onPageLoad(); }, true);
      savePQ();
      checkCurrentPage();
  }, // init: function()

// WHEN THE PAGE IS LOADED
  onPageLoad: function(loadEvent) {
    if (isVersionCorrect)
    {
        savePQ();
        checkCurrentPage();
    }
    } // onPageLoad: function(loadEvent)
} // var coagmentoToolbar
  
//SAVE CURRENT PAGE
function savePQ()
{
    if (isVersionCorrect)
    {
        // Create the request for saving the page (and query) and execute it
        updateLogginStatus();
        if (loggedIn)
        {
            var url = gBrowser.selectedBrowser.currentURI.spec;
            url = encodeURIComponent(url);
            var title = document.title;
            var xmlHttpTimeoutSavePQ;
            var xmlHttpConnectionSavePQ = new XMLHttpRequest();
            xmlHttpConnectionSavePQ.open('GET', 'http://www.coagmento.org/CSpace/savePQ.php?URL='+url+'&title='+title, true);
            xmlHttpConnectionSavePQ.onreadystatechange=function(){
                if (xmlHttpConnectionSavePQ.readyState == 4 && xmlHttpConnectionSavePQ.status == 200) {
                        clearTimeout(xmlHttpTimeoutSavePQ);
                      }
                }

            xmlHttpConnectionSavePQ.send(null);
            xmlHttpTimeoutSavePQ = setTimeout(function(){
                                                xmlHttpConnectionSavePQ.abort();
                                                clearTimeout(xmlHttpTimeoutSavePQ);
                                            }
                                            ,3000);
        }

   
    }
}

var isVersionCorrect = true;
// CHECK IF THE STATUS OF THE CURRENT PAGE, IF BOOKMARKED OR NOT
function checkCurrentPage()
{
    if(isVersionCorrect)
    {
        if (loggedIn)
        {
            var url = gBrowser.selectedBrowser.currentURI.spec;
            url = encodeURIComponent(url);
            var title = document.title;
            var req = new phpRequest("http://www.coagmento.org/CSpace/pageStatus.php");
            req.add('URL',url);
            req.add('title', title);
            req.add('version', getVersion());
            var response = req.execute();
                var button = document.getElementById("coagmento-Save-Button");
                var res = response.split(";");
                if (res[0]>0)
                {
                    if (res[1]==1)
                        button.label = "Remove";
                    else
                        button.label = "Bookmark";
                    setStatus(res);
                }
                else
                    {
                        if(isVersionCorrect)
                        {
                            isVersionCorrect = false;
                            disableButtons(true);
                            document.getElementById('coagmento-CSpaceLogin-Button').disabled = false;
                            document.getElementById('coagmento-Login-Button').disabled = true;
                            if(confirm("There is a new version available of Coagmento toolbar, do you want to Download it now?. If no, please visit your CSpace later to download it (Click the HOME button on the Coagmento Toolbar). Coagmento will not work until you get the latest version"))
                            {
                                window._content.document.location = res[6];
                            }
                        }
                    }
            /*var xmlHttpTimeoutCurrentPage;
            var xmlHttpCurrentPage = new XMLHttpRequest();
            xmlHttpCurrentPage.open('GET', 'http://www.coagmento.org/CSpace/pageStatus.php?'+'url='+url+'&title='+title, true);
            xmlHttpCurrentPage.onreadystatechange=function()
            {
                if (xmlHttpCurrentPage.readyState == 4 && xmlHttpCurrentPage.status == 200)
                {
                        var serverResponse = xmlHttpCurrentPage.responseText;
                        alert(serverResponse+":"+url);
                        var button = document.getElementById("coagmento-Save-Button");
                        var res = serverResponse.split(";");
                        if (res[1]==1)
                            button.label = "Remove";
                        else
                            button.label = "Bookmark";
                        setStatus(res);
                        xmlHttpCurrentPage.abort();
                        clearTimeout(xmlHttpTimeoutCurrentPage);
                }
            }

            xmlHttpCurrentPage.send(null);
            xmlHttpTimeoutCurrentPage = setTimeout(function(){
                                                xmlHttpCurrentPage.abort();
                                                clearTimeout(xmlHttpTimeoutCurrentPage);
                                            }
                                            ,7000);*/
        }
    }
}

 /*************************************************************************************************************************************/
 /*************************************************************************************************************************************/
 /******************************************************** USER ACTIONS ***************************************************************/
 /*************************************************************************************************************************************/
 /*************************************************************************************************************************************/
 /*************************************************************************************************************************************/

// Function to save or remove a page
function save() {

        //var loggedIn = isLogedIn(); //Check on Server
if (isVersionCorrect)
    {
	if (loggedIn) {
                var url = window.content.document.location;
		url = encodeURIComponent(url);
		var title = encodeURIComponent(document.title);
		//req = new phpRequest("http://www.coagmento.org/CSpace/checkStatus.php");
		//req.add('version',getVersion());
		//var response = req.execute();
		//var res = response.split(":");
		//if (res[0]>0) {
			var button = document.getElementById("coagmento-Save-Button");
			if (button.label == "Bookmark") {
                            //req = new phpRequest("http://www.coagmento.org/CSpace/saveResult.php");
                            //req.add('page', url);
                            //req.add('title', title);
                            //req.add('save','1');
                            //var response = req.execute();
                             var targetURL = 'http://www.coagmento.org/CSpace/saveResult.php?'+'page='+url+'&title='+title+'&save=1';
                             window.open(targetURL,'Bookmark','resizable=yes,scrollbars=yes,width=640,height=480,left=600');
                             button.label = "Remove";
			} // if (button.label == "Bookmark")
			else {
				req = new phpRequest("http://www.coagmento.org/CSpace/saveResult.php");
				req.add('page', url);
				req.add('title', title);
				req.add('save','0');
				var response = req.execute();
				button.label = "Bookmark";
			} // else with if (button.label == "Bookmark")
		//} // else with if (res[0]==0)
		//else {
		//	alert(res[1]);
		//}
	}
	else
		alert("Your session has expired. Please login again.");
    }
} // function save()

function recommend() {

        //var loggedIn = isLogedIn(); //Check on Server
if (isVersionCorrect)
    {
        if (loggedIn) {
		//req = new phpRequest("http://www.coagmento.org/CSpace/checkStatus.php");
		//req.add('version',getVersion());
		//var response = req.execute();
		//var res = response.split(":");
		//if (res[0]>0) {
			var url = window.content.document.location;
			url = encodeURIComponent(url);
			var title = encodeURIComponent(document.title);
                        var targetURL = 'http://www.coagmento.org/CSpace/recommend.php?'+'page='+url+'&title='+title;
                        window.open(targetURL,'Recommend','resizable=yes,scrollbars=yes,width=640,height=480,left=600');
		//} // if (loggedIn)
		//else {
		//	alert(res[1]);
		//}
	}
	else
		alert("Your session has expired. Please login again.");
    }
} // function annotate()

function annotate() {

        //var loggedIn = isLogedIn(); //Check on Server
if (isVersionCorrect)
    {
	if (loggedIn) {
		//req = new phpRequest("http://www.coagmento.org/CSpace/checkStatus.php");
		//req.add('version',getVersion());
		//var response = req.execute();
		//var res = response.split(":");
		//if (res[0]>0) {
			var url = window.content.document.location;
			url = encodeURIComponent(url);
			var title = encodeURIComponent(document.title);
                        var targetURL = 'http://www.coagmento.org/CSpace/annotations.php?'+'page='+url+'&title='+title;
                        window.open(targetURL,'Annotations','resizable=yes,scrollbars=yes,width=640,height=480,left=600');
		//} // if (loggedIn)
		//else {
		//	alert(res[1]);
		//}
	}
	else
		alert("Your session has expired. Please login again.");
    }
} // function annotate()

// Function to collect highlighted passage from the page as a snippet.
function snip() {

        //var loggedIn = isLogedIn(); //Check on Server
if (isVersionCorrect)
    {
	if (loggedIn) {
		//req = new phpRequest("http://www.coagmento.org/CSpace/checkStatus.php");
		//req.add('version',getVersion());
		//var response = req.execute();
		//var res = response.split(":");
		//if (res[0]>0) {
                        var snippet = document.commandDispatcher.focusedWindow.getSelection().toString();
                        var url = window.content.document.location;
                        url = encodeURIComponent(url);
                        var title = encodeURIComponent(document.title);
                        targetURL = 'http://www.coagmento.org/CSpace/saveSnippet.php?'+'URL='+url+'&snippet='+snippet+'&title='+title;
                        window.open(targetURL,'Snippet','resizable=yes,scrollbars=yes,width=640,height=480,left=600');
		//}
		//else {
                //      alert(res[1]);
		//}
	}
	else
		alert("Your session has expired. Please login again.");
    }
}

 // Function to load a URL in a popup window
function showSnippets() {
    if (isVersionCorrect)
    {
    var page = window.content.document.location;
	page = encodeURIComponent(page);
	var title = encodeURIComponent(document.title);
    url = 'http://www.coagmento.org/CSpace/snippets.php?1&page='+page+'&title='+title;
    window.open(url,'Snippets','resizable=yes,scrollbars=yes,width=640,height=480,left=600');
    }
}

//Change connection status from the toolbar
function changeConnectionStatus()
{
        if (document.getElementById("coagmento-Login-Button").label == "Disconnect")
        {
            if(confirm('Are you sure you want to logout?'))
            {
                req = new phpRequest("http://www.coagmento.org/CSpace/logout.php");
                var response = req.execute();
                var broadcaster = top.document.getElementById('viewSidebar');
                if (broadcaster.hasAttribute('checked'))
                    toggleSidebar('viewSidebar',false);
                updateLogginStatus();
            }
        }
        else
        {
            toggleSidebar('viewSidebar',false);
            toggleSidebar('viewSidebar',true);
            populateSidebar();
        }
}

 /*************************************************************************************************************************************/
 /*************************************************************************************************************************************/
 /*********************************************************** G U I *******************************************************************/
 /*************************************************************************************************************************************/
 /*************************************************************************************************************************************/
 /*************************************************************************************************************************************/

// Sidebar functions
function populateSidebar() {
	var sidebar = top.document.getElementById('sidebar');
        //var urlplace = "http://www.coagmento.org/loginOnSideBar.php";
        var urlplace = rootURL + "login.php";
	sidebar.setAttribute("src", urlplace);
}

function setStatus(res)
{
    var button = document.getElementById("coagmento-Views-Status-Button");
    button.label = res[2];
    var button = document.getElementById("coagmento-Notes-Status-Button");
    button.label = res[3];
    var button = document.getElementById("coagmento-Snippets-Status-Button");
    button.label = res[4];
    var button = document.getElementById("coagmento-Project-Status-Button");
    button.label = res[5];
}

function cleanStatus()
{
    var button = document.getElementById("coagmento-Views-Status-Button");
    button.label = "";
    var button = document.getElementById("coagmento-Notes-Status-Button");
    button.label = "";
    var button = document.getElementById("coagmento-Snippets-Status-Button");
    button.label = "";
    var button = document.getElementById("coagmento-Project-Status-Button");
    button.label = "";
}

//DISABLE OR ENABLE BUTTONS
function disableButtons(value)
{
    //if (isVersionCorrect)
    //{
        document.getElementById('coagmento-CSpaceLogin-Button').disabled = value;
        document.getElementById('coagmento-Save-Button').disabled = value;
        document.getElementById('coagmento-Recommend-Button').disabled = value;
        document.getElementById('coagmento-Annotate-Button').disabled = value;
        document.getElementById('coagmento-Snip-Button').disabled = value;
        document.getElementById('coagmento-Sidebar-Button').disabled = value;
        document.getElementById('coagmento-Etherpad-Button').disabled = value;
        document.getElementById('coagmento-Views-Status-Button').disabled = value;
        document.getElementById('coagmento-Notes-Status-Button').disabled = value;
        document.getElementById('coagmento-Snippets-Status-Button').disabled = value;
        document.getElementById('coagmento-Project-Status-Button').disabled = value;
        //document.getElementById('coagmento-Mood-Menupopup').disabled = value;
        //if (value==true)
        //    document.getElementById('coagmento-Mood-Menupopup').label = "How do you feel now?";
    //}
}

/*************************************************************************************************************************************/
 /*************************************************************************************************************************************/
 /************************************************************ LOGIN ******************************************************************/
 /*************************************************************************************************************************************/
 /*************************************************************************************************************************************/
 /*************************************************************************************************************************************/

var connectionFlag = false;
var loggedIn = false;

//Check if session is alive on Server
function updateLogginStatus()
{
    if (isVersionCorrect)
    {
        checkConnectivity();
        updateToolbarButtons();
    }
}

function updateToolbarButtons()
{
    if (isVersionCorrect)
    {
    if (connectionFlag)
    {
            document.getElementById('coagmento-Login-Button').disabled = false;
            if (loggedIn)
            {
                //loggedIn = true;
                disableButtons(false);
                document.getElementById("coagmento-Login-Button").label = "Disconnect";
            }
            else
            {
                disableButtons(true);
                document.getElementById("coagmento-Login-Button").label = "Connect";
                cleanStatus();
            }

     }
    }
}

 /*************************************************************************************************************************************/
 /*************************************************************************************************************************************/
 /**************************************************** CONNECTIVITY *******************************************************************/
 /*************************************************************************************************************************************/
 /*************************************************************************************************************************************/
 /*************************************************************************************************************************************/

var isExclusive = false;

// Some parts of the function below were taken from http://stackoverflow.com/questions/1018705/how-to-detect-timeout-on-an-ajax-xmlhttprequest-call-in-the-browser
function checkConnectivity()
{   
    connectionFlag = true;
    /*
    if (isVersionCorrect)
    {
    var xmlHttpTimeout;
    if (isExclusive==false)
    {
        isExclusive = true;
        var xmlHttpConnection = new XMLHttpRequest();
        xmlHttpConnection.open('GET', 'http://www.coagmento.org/CSpace/checkConnectionStatus.php', true);
        xmlHttpConnection.onreadystatechange=function(){
              if (xmlHttpConnection.readyState == 4 && xmlHttpConnection.status == 200) {
                    var serverResponse = xmlHttpConnection.responseText;
                    if (serverResponse!=0)
                    {
                        if (serverResponse==1) //If response == 1 then session active
                            loggedIn = true;
                        else                  //If response == 1 then NO session active
                            loggedIn = false;
                        xmlHttpConnection.abort();
                        clearTimeout(xmlHttpTimeout);
                        document.getElementById('coagmento-Login-Button').disabled = false;
//                        document.getElementById('coagmento-ServerConnection-Status').label = " -- Server Connectivity: OK -- ";
                        connectionFlag = true;
                        updateToolbarButtons();
                        isExclusive = false;
                    }
                    else
                        {
                            clearTimeout(xmlHttpTimeout);
                            serverDown();
                            xmlHttpConnection.abort();
                        }
              }
        }

        xmlHttpConnection.send(null);
        xmlHttpTimeout = setTimeout(function (){
                                        serverDown();
                                        xmlHttpConnection.abort();
                                        clearTimeout(xmlHttpTimeout);
                                    },5000);
                                    }
    
  
    }
    */
 }

 function serverDown()
 {
       connectionFlag = false;
       disableButtons(true);
       document.getElementById("coagmento-Login-Button").label = "Connect";
       cleanStatus();
       document.getElementById('coagmento-Login-Button').disabled = true;
//       document.getElementById('coagmento-ServerConnection-Status').label = " -- Server Connectivity: FAIL -- ";
       var broadcaster = top.document.getElementById('viewSidebar');
                if (broadcaster.hasAttribute('checked'))
                    toggleSidebar('viewSidebar',false);
       isExclusive = false;
 }


 /*************************************************************************************************************************************/
 /*************************************************************************************************************************************/
 /**************************************************** PHP REQUESTS / LOAD URLs / *****************************************************/
 /*************************************************************************************************************************************/
 /*************************************************************************************************************************************/
 /*************************************************************************************************************************************/


// Function to load a URL
function loadURL(url) {
    // Set the browser window's location to the incoming URL
    window._content.document.location = url;

    // Make sure that we get the focus
    window.content.focus();
}

function search() {
	var searchString = document.getElementById("coagmento-SearchTerms").value;
	var url = 'http://www.coagmento.org/CSpace/index.php?search='+searchString;
	loadURL(url);
}

// Function to load a URL in a popup window
function loadURLPopup(url, text) {
	var page = window.content.document.location;
    url = url+'?1&page='+page;
    window.open(url,text,'resizable=yes,scrollbars=yes,width=640,height=480,left=600');
}

//Start phpRequest Object
function phpRequest(serverScript) {
	//Set some default variables
	this.parms = new Array();
	this.parmsIndex = 0;

	//Set the server url
	this.server = serverScript;

	//Add two methods
	this.execute = phpRequestExecute;
	this.add = phpRequestAdd;
}

// Add parameters to for creating an HTTP request with PHP.
function phpRequestAdd(name,value) {
    //Add a new pair object to the params
    this.parms[this.parmsIndex] = new pair(name,value);
    this.parmsIndex++;
}

// Execute an HTTP request.
function phpRequestExecute() {
    //Set the server to a local variable
    var targetURL = this.server;

    //Try to create our XMLHttpRequest Object
    try {
        var httpRequest = new XMLHttpRequest();
    }
    catch (e) {
//        alert('Error creating the connection!');
        return;
    }

    //Make the connection and send our data
    try {
        var txt = "?1";
        for(var i in this.parms) {
            txt = txt+'&'+this.parms[i].name+'='+this.parms[i].value;
        }
        //Two options here, only uncomment one of these
        //GET REQUEST
		var currentURL = targetURL+txt;
	        httpRequest.open("GET", currentURL, false, null, null);
	        httpRequest.send('');
    }
    catch (e) {
//        alert('An error has occured calling the external site: '+e);
        return false;
    }

    //Make sure we received a valid response
    switch(httpRequest.readyState) {
        case 1,2,3:
 //           alert('Bad Ready State: '+httpRequest.status);
            return false;
            break;
        case 4:
            if(httpRequest.status !=200) {
 //               alert('The server respond with a bad status code: '+httpRequest.status);
                return false;
            }
            else {
                var response = httpRequest.responseText;
            }
            break;
    }
    return response;
}

// Pair a parameter name and its value.
function pair(name,value) {
    this.name = name;
    this.value = value;
}

function setMood(value, label)
{
    if (isVersionCorrect)
    {
	if (loggedIn) {
            //document.getElementById('coagmento-Mood-Menupopup').label = "How do you feel now? " + label;
            var xmlHttpTimeoutChangeMood;
            var xmlHttpConnectionChangeMood = new XMLHttpRequest();
            xmlHttpConnectionChangeMood.open('GET', 'http://www.coagmento.org/CSpace/changeMood.php?value='+value, true);
            xmlHttpConnectionChangeMood.onreadystatechange=function(){
                if (xmlHttpConnectionChangeMood.readyState == 4 && xmlHttpConnectionChangeMood.status == 200) {
                        clearTimeout(xmlHttpTimeoutChangeMood);
                      }
                }

            xmlHttpConnectionChangeMood.send(null);
            xmlHttpTimeoutChangeMood = setTimeout(function(){
                                                xmlHttpTimeoutChangeMood.abort();
                                                clearTimeout(xmlHttpConnectionChangeMood);
                                            }
                                            ,3000);
        }
    }
}

function login(){
    var uname = document.getElementById("username");
    alert(uname.value);
    uname.disabled = true;
    uname.parentNode.removeChild(uname);
}
