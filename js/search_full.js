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
        "search_input_title", "search_input_authors",
        "search_input_description", "search_input_year",
        "search_input_isbn", "search_input_publisher"
      ],
      searchFullResults,
      searchNotEmpty
    );
  });
}

// Makes sure there's actually stuff being searched for
function searchNotEmpty(settings) {
  for(var i in settings)
    if(settings[i]) return true;
  holderSayEmpty();
  return false;
}

// Display JSON search results as HTML elements
function searchFullResults(results_raw) {
  console.log("results raw", results_raw);
  // If nothing is returned, set the import message
  if(!results_raw || results_raw == "[]")
    holderSayEmpty();
  // Otherwise generate the output for it
  else {
    var results = JSON.parse(results_raw),
        output = "",
        result, i;
    for(i in results) {
      result = results[i];
      output += printBookDisplaySmall(result);
    }
    $("#search_form_results").html(output);
  }
}

function holderSayEmpty() {
  $("#search_form_results").html("<div class='warning'>Nothing yet, but keep in mind you can also <a href='import.php'>import</a> books to our database.</div>");
}

// Generates an HTML listing for something
function printBookDisplaySmall(result) {
  var output = "";
  output += "  <div class='display_book display_book_small'>\n";
  output += "    <div class='display_book_info'>\n";
  output += "      <h1>\n";
  output += "        <div class='display_book_year'>" + result.year + "</div>\n";
  output += "        <a href='book.php?isbn=" + result.isbn + "'>" + result.title + "</a>\n";
  output += "        <aside>(" + result.authors + ")</aside>\n";
  output += "      </h1>\n";
  output += "    </div>\n";
  output += "    <div class='display_book_description'>\n";
  output += "      <blockquote>" + strLimitLength(result.description, 210) + "</blockquote>\n";
  output += "    </div>\n";
  output += "  </div>";
  return output.replace("\\n", ', ').replace("\\\nn", ', ');
}
function strLimitLength(str, len) {
  if(str.length > len - 3) {
    var out = str.substr(0, len - 3);
    return out.substr(0, out.lastIndexOf(" ")) + "...";
  }
  return str;
}