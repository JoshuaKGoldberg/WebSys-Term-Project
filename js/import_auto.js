/* Import script */
/* General program flow: 
  1. Get the list of book URLs from the PHP script, which gives http://sis.rpi.edu/reg/zs20XXYY.htm, where...
    a. XX is the year (e.g. '13' from 2013)
    b. YY is the starting month (e.g. '09' from Fall 2013)
  2. Get all string indexes '<A href="http://www.bkstr.com/webapp' starts
  3. Get the subsequent URLs from those locations
  4. Start loading the URLs
  5. Give the arguments to PHP to request the page
  6. Take the ISBN and add it to the database
*/

// 1. Get the list of book URLs from the PHP script
function importStart() {
  sendRequest("publicGetSIS", {}, importGetLocations);
  // If 3.5s from now, if it failed, complain
  setTimeout(function() {
    if(!window.import_adders_id) {
      window.import_adders_id = -1;
      document.getElementById("imports_holder").innerHTML = "<h2>Request failed; please try again.";
    }
  }, 35000);
}

// 2. Get all string indexes of '<A href="http://www.bkstr.com/webapp' starts
function importGetLocations(page) {
  // If the request already timed out, don't do anything
  if(window.import_adders_id == -1) return;
  importGetURLS(page, getStringLocationsOf(page, '<A href="http://www.bkstr.com/webapp'));
}
function getStringLocationsOf(haystack, needle) {
  var index = -1,
      results = [];
  while((index = haystack.indexOf(needle, index + 1)) > -1)
    results.push(index);
  return results;
}

// 3. Get the subsequent URLs from those locations
function importGetURLS(page, locs) {
  var container = document.getElementById("imports_holder"),
      loc, loc_end;
  window.import_adders_id = 1;
  for(i = 0, len = locs.length; i < len; ++i) {
    loc = locs[i];
    // Get the starting quotation
    loc = page.indexOf("http", loc);
    // Get the ending location
    loc_end = page.indexOf('"TARGET="_blank"', loc);
    // Run that URL
    importAddURL(page.substring(loc, loc_end), container);
  }
}

// 4. Start loading the URLs
function importAddURL(url, container) {
  var element = document.createElement("div"),
      id = ++window.import_adders_id;
  element.id = "import_adder_" + id;
  element.innerHTML = "<strong>Loading: </strong> " + url.substr(0, 35) + "..." + url.substr(url.length - 70);
  container.appendChild(element);
  // importGrabBookSISPage(url, element.id)
}

// 5. Give the arguments to PHP to request the page
function importGrabBookSISPage(url, element_id) {
  sendRequest("publicGetSIS", {
    url_arguments: url.substr(url.indexOf("?") + 1),
    element_id: element_id
  }, importReportBookISBN);
}

// 6. Take the ISBN and add it to the database
function importReportBookISBN(isbn) {
  alert("ISBN is" + isbn);
}