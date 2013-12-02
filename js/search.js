/* Searches (done by the header search bar)
*/

// Start the searches
function searchStart() {
  setTimeout(function() {
    var value = $("#header_search_input").val().trim(),
        args = { value: value },
        columns, arg;
        arg;
    
    // Make sure only the most recent request is continued
    if(!window.search_request_num) window.search_request_num = 1;
    else ++window.search_request_num;
    
    // If nothing was searched, clear it
    if(!value) {
      $("#header_search_results div").html("");
      $("#header_search_results").removeClass("filled").removeClass("search_complaint");
      return;
    }
    
    // If a number is given, just search on ISBN
    if(!isNaN(value))
      columns = ["isbn"];
    // Otherwise search on a few fields
    columns = ["title", "authors", "description"];
    
    // Run a search on each of the columns
    for(arg in columns) {
      args.number = arg;
      args.column = columns[arg];
      sendRequest("publicSearch", args, function() { searchGetResult(arguments[0], window.search_request_num) });
    }
  });
}

// Results are the column name, a space, then a JSON-encoded array of book info
function searchGetResult(results, count) {
  // Make sure this is the latest request
  if(!results || count < window.search_request_num) return;
  
  var splitter = results.indexOf(" "),
      column = results.substr(0, splitter),
      books_raw = results.substr(splitter + 1),
      books;
  
  // Display the results as decoded by JSON
  books = JSON.parse(books_raw);
  searchDisplayResults(column, books);
}

// Displays search results under the appropriate section
function searchDisplayResults(column, books) {
  var output = "<aside style='padding-top:14px;'>by " + column + ":</aside>",
      col_id = "search_results_" + column,
      holder, book, i;
  
  // Add each book's summary to the output
  for(i in books) {
    book = books[i];
    output += "<div class='book'>";
    output += "<div class='year'><aside>" + book.year + "</aside></div>";
    output += "<strong><a href='book.php?isbn=" + book.isbn + "'>" + book.title + "</a></strong>";
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
  
  // If there aren't any books, the output is blank
  if(!books.length) {
    holder.html("");
    // If there aren't any results, complain
    if(!$("header_search_results").text().trim()) {
      if(!window.search_complaining) {
        window.search_complaining = true;
        $("#header_search_results").addClass("search_complaint")
          .append("<div id='header_search_nothing'>* Try <a href='search.php'>refining your search</a>.</div>");
      }
    }
    return;
  }
  // Otherwise make sure there isn't a complaint
  if(window.search_complaining) {
    $("#header_search_nothing").remove();
    window.search_complaining = false;
  }
  
  // Set the holder to contain this html, and update the parent class
  holder.html(output);
  $("#header_search_results").addClass("filled");
}