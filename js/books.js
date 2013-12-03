/* Handlers for the Google Books API v1
 * https://developers.google.com/books/docs/v1/using
*/

// For each placeholder entries list, send the actual request
function startLoadingBookEntries(isbn) {
  var div, action;
  $(".display_entries_in").each(function() {
    div = arguments[1],
    action = div.id.replace("display_entries_", "");
    loadBookEntries(isbn, action);
  });
}

// Loads the entries for a given book that are of the given action
// sendRequest("publicGetBookEntries", {isbn: 9780073523323, action: "sell"}, function() { console.log(JSON.parse(arguments[0])); })
function loadBookEntries(isbn, action) {
  sendRequest("publicGetBookEntries", {
    isbn: isbn,
    action: action
  }, function(entries_raw) { getBookEntries(entries_raw, action); });
}
function getBookEntries(entries_raw, action) {
  var entries = JSON.parse(entries_raw),
      holder = $("#display_entries_" + action + " .display_entries_list");
  
  // If there aren't any entries, set the holder to have nothing
  if(!entries.length) {
    holder.html("None found!");
    return;
  }
  
  // Sort the entries by condition
  entries.sort(sortBookEntries);
  
  // Since there are some, make a list of them
  var output = "", i;
  for(i in entries)
    output += getBookEntryListing(entries[i]) + "\n";
  
  holder.html(output);
}

// See settings.php:: bookStates
function sortBookEntries(a, b) {
  return getBookCondValue(a) > getBookCondValue(b);
}
function getBookCondValue(a) {
  return ['like new', 'very good', 'good', 'fair', 'poor', 'terrible'].indexOf(a.state.toLowerCase());
}

function getBookEntryListing(entry) {
  var output = "<li>";
  console.log(entry);
  output += "<a class='normal' href='/users.php?user=" + entry.user_id + "&entry=" + entry.entry_id + "'>" + entry.username + "</a>";
  output += "for <strong>$" + Number(entry.price).toFixed(2) + "</strong> <em>(" + entry.state + " <small>condition</small>)</em>";
  output += "</li>";
  return output;
}

// Attempts to add a book to the database
function addBookISBN(isbn) {
  sendRequest("publicAddBook", {
    "isbn": isbn,
  }, getAddBookResult);
}
function getAddBookResult() {
  console.log(arguments[0]);
}