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

function joinSubmit() {
  var username = $("#username").val(),
      password = $("#password").val(),
      email    = $("#email").val();
  
  
  return false; // to stop reloading
}
