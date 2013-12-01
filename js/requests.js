// sendRequest("func_name", {settings}, callback)
// * Sends an AJAX request to a PHP function func_name
// * Arguments are given by the settings object
// * Callback is called when it's done
function sendRequest(func_name, settings, callback) {
  var url = "php/requests.php?",
      args = [],
      s_name;
  
  // Generate the list of arguments
  settings["Function"] = func_name;
  for(s_name in settings)
    args.push(s_name + "=" + settings[s_name]);
  
  // Add those arguments to the url
  url += args.join("&");
  
  // Create and return the jqXHR object
  return $.ajax({
    url: url
  }).done(callback);
}