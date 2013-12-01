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
      info = results.substr(splitter + 1),
      parsed;
  
  // Display the results as decoded by JSON
  parsed = JSON.parse(info);
  searchDisplayResults(column, parsed);
}

// Displays search results under the appropriate section
function searchDisplayResults(column, parsed) {
  console.log("Almost there!", column, parsed);
}