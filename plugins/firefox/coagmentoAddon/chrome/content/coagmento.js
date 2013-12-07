pref("dom.allow_scripts_to_close_windows", true);
// Add a listener to the current window.
var rootURL = "http://localhost/coagmentoCollaboratory/plugins/pages/";
var userID = -1;
var userKey = null;
var msgTimer = null;
var initialized = false;
var pageBookmarked = -1;//-1 if not, bookmark id if it is
var annotationWindow;
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
       // logPage();
        checkCurrentPage();
    }
}

var addressChangeListener = {
    onLocationChange: function(aProgress, aRequest, aURI) {
        logPage();
    },

    onStateChange: function() {},
    onProgressChange: function() {},
    onStatusChange: function() {},
    onSecurityChange: function() {}
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
        if(!initialized){
          initialized= true;
          gBrowser.addProgressListener(addressChangeListener);
        }
      savePQ();
     // logPage();
      checkCurrentPage();
  }, // init: function()

// WHEN THE PAGE IS LOADED
  onPageLoad: function(loadEvent) {
    if (isVersionCorrect)
    {
        savePQ();
        logPage();
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

function logPage(){
    if(userID != -1){
        var d = new Date();
        var data = {
            "url" : gBrowser.selectedBrowser.currentURI.spec,
            "title" : document.title,
            "startDate" :  d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate(),
            "startTime" : d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds(),
            "projectID" :  getSelectedProject(),
        };
        sendRequest("http://localhost/coagmentoCollaboratory/webservices/index.php", "page", data, userID, "create", userKey);
    }
}

var isVersionCorrect = true;

// CHECK IF THE STATUS OF THE CURRENT PAGE, IF BOOKMARKED OR NOT
function checkCurrentPage()
{
    if(userID != -1){
        var data = {
            "url" : gBrowser.selectedBrowser.currentURI.spec,
            "type" : "user_test"
        };
        var onComp = function(xhr,stat){
            //alert(stat);
            var button = document.getElementById("coagmento-Save-Button");
            //alert(xhr.responseText);
            var resp = $.parseJSON(xhr.responseText);
            if(resp.userHasBookmark){
                pageBookmarked = resp.id;
                button.label = "Remove";
            }
            else{
                pageBookmarked = -1;
                button.label = "Bookmark";
            }
        };
        sendRequest("http://localhost/coagmentoCollaboratory/webservices/index.php", "bookmark", data, userID, "retrieve", userKey, onComp, "json");
    }
}

 /*************************************************************************************************************************************/
 /*************************************************************************************************************************************/
 /******************************************************** USER ACTIONS ***************************************************************/
 /*************************************************************************************************************************************/
 /*************************************************************************************************************************************/
 /*************************************************************************************************************************************/

function bookmark(){
  var projID = getSelectedProject();
  if(projID == -1){
    message("No project selected");
    return;
  }
  if(pageBookmarked == -1){
      var url = gBrowser.selectedBrowser.currentURI.spec;
      var title = document.title;
      var data = {
        'url' : url,
        'title' : title,
        'projectID' : projID
      };
      var onComp = function(xhr, stat){
        message("Bookmark saved!");
        checkCurrentPage();
      }
      sendRequest("http://localhost/coagmentoCollaboratory/webservices/index.php", "bookmark", data, userID, "create", userKey, onComp);
  }
  else{
    //remove bookmark
    var data = {
        "id" : pageBookmarked
    };
    var onComp = function(xhr, stat){
        message("Bookmark removed!");
        checkCurrentPage();
    }
    sendRequest("http://localhost/coagmentoCollaboratory/webservices/index.php", "bookmark", data, userID, "delete", userKey, onComp);
  }
}
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
} 

function saveAnnotation(content){
  if(userID == -1){
    message ("Not logged in");
    return;
  }
  var projID = getSelectedProject();
  if(projID == -1){
    message("No project selected");
    return;
  }
  var url = gBrowser.selectedBrowser.currentURI.spec;
  var title = document.title;
  var data = {
    'annotation' : content,
    'url' : url,
    'title' : title,
    'projectID' : projID
  };
  var onComp = function(xhr,stat){
    message("Annotation saved!");
  };
  annotationWindow.close();
  sendRequest("http://localhost/coagmentoCollaboratory/webservices/index.php", "annotation", data, userID, "create", userKey, onComp);
}

function openAnnotateWindow() {
  var w = 200;
  var h = 150;
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  //open annotation window
  annotationWindow = window.open("chrome://coagmento/content/annotate.xul", "annotate", 'chrome,width='+w+',height='+h+',top='+top+',left='+left);
}

function test(){
  alert("From coagmento.js");
}
// Function to collect highlighted passage from the page as a snippet.
function message(msg){
  document.getElementById("msgs").textContent = msg;
  msgTimer = window.clearTimeout(msgTimer);
  msgTimer = window.setTimeout(cleanAlert, 5000);
}
function cleanAlert()
{
    document.getElementById('msgs').textContent = "";
}
function snip(){
  if(userID == -1){
    message ("Not logged in");
    return;
  }
  var projID = getSelectedProject();
  if(projID == -1){
    message("No project selected");
    return;
  }
  var snippet = document.commandDispatcher.focusedWindow.getSelection().toString();
  snippet = snippet.trim();
  if(snippet == ""){
    message("Nothing selected! Snippet not saved.");
    return;
  }
  var url = gBrowser.selectedBrowser.currentURI.spec;
  var title = document.title;
  var data = {
    'snippet' : snippet,
    'note' : "",
    'url' : url,
    'title' : title,
    'projectID' : projID
  };
  var onComp = function(xhr,stat){
    //alert(stat);
    //alert(xhr.responseText);
    message("Snippet saved!");
  };
  sendRequest("http://localhost/coagmentoCollaboratory/webservices/index.php", "snippet", data, userID, "create", userKey, onComp);
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
  /*
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
    */
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
       // var urlplace = rootURL + "login.php";
	//sidebar.setAttribute("src", urlplace);
}

function setStatus(res)
{
  /*
    var button = document.getElementById("coagmento-Views-Status-Button");
    button.label = res[2];
    var button = document.getElementById("coagmento-Notes-Status-Button");
    button.label = res[3];
    var button = document.getElementById("coagmento-Snippets-Status-Button");
    button.label = res[4];
    var button = document.getElementById("coagmento-Project-Status-Button");
    button.label = res[5];
    */
}

function cleanStatus()
{
  /*
    var button = document.getElementById("coagmento-Views-Status-Button");
    button.label = "";
    var button = document.getElementById("coagmento-Notes-Status-Button");
    button.label = "";
    var button = document.getElementById("coagmento-Snippets-Status-Button");
    button.label = "";
    var button = document.getElementById("coagmento-Project-Status-Button");
    button.label = "";
    */
}

//DISABLE OR ENABLE BUTTONS
function disableButtons(value)
{
    //if (isVersionCorrect)
    //{
    //    document.getElementById('coagmento-CSpaceLogin-Button').disabled = value;
        document.getElementById('coagmento-Save-Button').disabled = value;
        document.getElementById('coagmento-Recommend-Button').disabled = value;
        document.getElementById('coagmento-Annotate-Button').disabled = value;
        document.getElementById('coagmento-Snip-Button').disabled = value;
    //    document.getElementById('coagmento-Sidebar-Button').disabled = value;
    //    document.getElementById('coagmento-Etherpad-Button').disabled = value;
    //    document.getElementById('coagmento-Views-Status-Button').disabled = value;
    //    document.getElementById('coagmento-Notes-Status-Button').disabled = value;
    //    document.getElementById('coagmento-Snippets-Status-Button').disabled = value;
    //    document.getElementById('coagmento-Project-Status-Button').disabled = value;
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
               // disableButtons(true);
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
  /*
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

      */
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
	/*var searchString = document.getElementById("coagmento-SearchTerms").value;
	var url = 'http://www.coagmento.org/CSpace/index.php?search='+searchString;
	loadURL(url);*/
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

function getSelectedProject(){
    var list = document.getElementById("projectList");
    var sel = list.selectedItem;
    if(sel){
        return parseInt(sel.getAttribute("value"));
    }
    return -1;
}

function populateProjects(){
    if(userID == -1){return;}
    var data = { "type" : "user" };
    function succ(xhr,stat){
        var resp = $.parseJSON(xhr.responseText);
        if(resp.hasOwnProperty("error")){
            message(resp.error);
        }
        else{
            var popup = document.getElementById("projectPopup");
            //remove all children first
            while(popup.firstChild){
              popup.removeChild(popup.firstChild);
            }
            for(var i = 0; i < resp.length; i++){
                var p = resp[i];
                var mi = document.createElement("menuitem");
                mi.setAttribute("label", p.title);
                mi.setAttribute("value", p.projectID);
                popup.appendChild(mi);
            }   
        }
    }
    sendRequest("http://localhost/coagmentoCollaboratory/webservices/index.php", "project", data, userID, "retrieve", userKey, succ, "json");
}

function login(){
    var btn = document.getElementById("login");
    var lbluname = document.getElementById("lbluname");
    var lblpass = document.getElementById("lblpass");
    var unamebox = document.getElementById("username");
    var passbox = document.getElementById("password");
    var uname = unamebox.value;
    var pass = passbox.value;

    if(userID != -1){
      //user is trying to log out
      userID = -1;
      userKey = null;
      passbox.hidden = false;
      unamebox.hidden = false;
      lbluname.hidden = false;
      lblpass.hidden = false;
      btn.label = "Log in";
      disableButtons(true);
      message("Logged out");
      return;
    }

    function succ(xhr,stat){
        var resp = $.parseJSON(xhr.responseText);
        if(resp.hasOwnProperty("error")){
            message(resp.error);
        }
        else{
            //success
            message("Logged in!");
            userID = resp.userID;
            userKey = resp.key;
            passbox.hidden = true;
            unamebox.hidden = true;
            lbluname.hidden = true;
            lblpass.hidden = true;
            btn.label = "Log out";
            disableButtons(false);
            //get a list of user's projects, and add them to a drop down menu
            populateProjects();
            checkCurrentPage();
            logPage();
        }
    }
    var data = {
        "username" : uname,
        "password" : pass
    };
    sendRequest("http://localhost/coagmentoCollaboratory/webservices/index.php", "user", data, -1, "retrieve", "nokey", succ, "json");
}
