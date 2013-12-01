// Displays a little popup next to an input (in the div.complaint)
// Sample usage: joinComplainOn("username", "That username is taken!", true)
function joinComplainOn(holder, message, severe) {
  joinComplainGet(holder).html(joinCreateComplaint(message, severe));
}
function joinComplainOff(holder) {
  joinComplainGet(holder).html("");
}
function joinComplainGet(holder) {
  return $("#hold_" + holder + " .hold_complaint");
}

function joinCreateComplaint(message, severe) {
  var elem = document.createElement("div");
  elem.className = "complaint " + (severe ? "severe" : "normal");
  elem.innerHTML = message;
  return elem;
}

// Called by hitting the submit button on the signup form
// Tells the server to attempt to create a new user
function joinSubmit() {
  // Make sure the fields aren't empty
  var username = $("#username").val(),
      password = $("#password").val(),
      email = $("#email").val(),
      ok = 0;
  ok += joinCheckValid("username", username, 4);
  ok += joinCheckValid("password", password);
  ok += joinCheckValid("email", email);
  if(ok != 3) return;
  
  // Stop the user from accidentally spamming requests
  var joinSubmitOld = window.joinSubmit;
  window.joinSubmit = false;
  setTimeout(function() { window.joinSubmit = joinSubmitOld; }, 1400);
  
  // Visually update the button#submit
  $("#submit").val("thinking...").attr("disabled", false);
  
  // Run the call to create the user
  sendRequest("publicCreateUser", {
    "username": username,
    "password": password,
    "email": email
  }, joinComplete);
  
  return;
}

// Makes sure a given field isn't empty or too short
function joinCheckValid(name, value, length) {
  length = length || 7;
  if(!value)
    joinComplainOn(name, "A <b>" + name + "</b> must be provided!", true);
  else if(value.length < length)
    joinComplainOn(name, "Your <b>" + name + "</b> is <b>too short</b> (by " + (length - value.length) + ")");
  else {
    joinComplainOff(name);
    return 1;
  }
  return 0;
}

// Run when the signup script finishes
function joinComplete(text) {
  // If text is blank, it was successful
  if(!text) {
    var message = "Your user account has successfully been created! ";
    message += "You should be redirected to ";
    message += "<a href='/account.php'>your account page</a>";
    message += " shortly; if not, click that link.";
    $("#pledge").html("<aside>" + message + "</aside>");
    $("#submit").remove();
  }
  // Otherwise text contains the error
  else {
    $("#pledge").html("<aside>" + text + "</aside>");
    $("#submit").html("Sign me up!");
  }
}