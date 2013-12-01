/* Searches (done by the header search bar)
*/

// Start the searches
function searchStart() {
  var value = $("#header_search_input").val(),
      args = { value: value },
      columns, arg;
      arg;
  
  // If a number is given, just search on ISBN
  if(!isNaN(value))
    columns = ["isbn"];
  // Otherwise search on a few fields
  columns = ["title", "authors", "description"];
  
  // Run a search on each of the columns
  for(arg in columns) {
    args.number = arg;
    args.column = columns[arg];
    sendRequest("publicSearch", args, searchGetResult);
  }
}

// Results are the column name, a space, then a JSON-encoded array of book info
function searchGetResult() {
  var results = arguments[0],
      splitter = results.indexOf(" "),
      column = results.substr(0, splitter),
      books_raw = results.substr(splitter + 1),
      books;
  
  // Display the results as decoded by JSON
  books = JSON.parse(books_raw);
  searchDisplayResults(column, books);
}

// Displays search results under the appropriate section
function searchDisplayResults(column, books) {
  var output = "<h4>by " + column + ":</h4>",
      col_id = "search_results_" + column,
      holder, book, i;
  
  // Add each book's summary to the output
  for(i in books) {
    book = books[i];
    output += "<div class='book'>";
    output += "<strong>" + book.title + "</strong>";
    output += "</div>";
  }
  
  // Ensure div#search_results_{column} exists
  holder = $("#" + col_id);
  // (if it doesn't make, it)
  if(holder.length == 0) {
    var created = document.createElement("div");
    created.id = col_id;
    $("#header_search_results").append(created);
    holder = $("#" + col_id);
  }
  
  // Set the holder to contain this html, and update the parent class
  holder.html(output);
  $("#header_search_results").addClass("filled");
}