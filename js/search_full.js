/* Full searches (done by search.php)
*/

// So concise
// Much elegant
// Wow
function searchFull() {
  setTimeout(function() {
    sendRequestForm(
      "publicSearchFull",
      [
        "search_input_name", "search_input_authors",
        "search_input_description", "search_input_year",
        "search_input_isbn", "search_input_publisher"
      ],
      searchFullResults
    );
  });
}

// Display JSON search results as HTML elements
function searchFullResults(results_raw) {
  var holder = $("#search_form_results"),
      results,
      output;
  // If nothing is returned, set the import message
  if(!results_raw || results_raw == "[]") {
    holder.html("<aside>Nothing yet, but keep in mind you can also <a href='import.php'>import</a> books to our database.</aside>");
  }
  // Otherwise generate the output for it
  else {
    results = JSON.parse(results_raw);
    console.log(results);
  }
}