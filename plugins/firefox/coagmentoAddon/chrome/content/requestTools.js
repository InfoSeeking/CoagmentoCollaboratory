//jQuery required, sha1 required
/**
  *@param function onComplete function called after request completes
  */

function sendRequest(url, path, data, userID, action, privateKey, onComplete, dtype){
   var data_str = $.param(data);
   var hashed_data = CryptoJS.SHA1(data_str + "|" + userID + "|" + privateKey);
   hashed_data = "" + hashed_data;

   var post_data = {
    "data" : data_str,
    "hashed_data" : hashed_data,
    "userID" : userID,
    "action" : action
   };
   if(dtype){
    post_data['datatype'] = dtype;
   }
   $.ajax({
    "url" : url + "/" + path,
    "type" : "POST",
    "data" : post_data,
    "complete": onComplete
   });
}
