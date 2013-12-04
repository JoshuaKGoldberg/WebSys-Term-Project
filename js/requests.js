/* Our Small Requests Framework */
/*
This enables users to run a PHP function (func_name) with
a set of arguments (settings), and send the results to a
callback function (callback).

The callback function must:
* Exist in php/public_functions.php
* Have its name declared in $allowed_functions in settings.php

For example, the following will console.log each given argument:

PHP function
------------
function publicHelloWorld($arguments) {
  foreach($arguments as $key=>$argument) {
    echo 'Argument is ' . $key . ' -> ' . $argument . '\n';
  }
}

Javascript function
-------------------
sendRequest("publicHelloWorld", {
  first_variable: 'my first value',
  second_variable: 'hello momma!',
  third_variable: 'we're done here.'
}, function(text) { console.log(text); });

Output
------
"
Argument is first_variable -> my first value
Argument is second_variable -> hello momma!
Argument is third_variable -> we're done here.
"

*/

// sendRequest("func_name", {settings}[, callback])
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
  }).done(callback || function() {});
}

// sendRequestForm("func_name", ["ids"][, callback[, validation]])
// A specialized helper that calls sendRequest with the values of forms
// Form IDs are given in [ids]
// An extra optional validation function is allowed
function sendRequestForm(func_name, ids, callback, validation) {
  var settings = {},
      elem, id, i;
      
  // For each of the given IDs:
  for(i in ids) {
    id = ids[i];
    // If an element matches that ID, add it to settings
    elem = document.getElementById(id);
    settings[id] = elem ? elem.value : "";
  }

  // If a validation function is provided, make sure it's ok
  if(validation && !validation(settings))
    return;
  
  // Since you're good, run the request normally
  sendRequest(func_name, settings, callback);
}