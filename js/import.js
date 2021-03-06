/* Manual Imports
 * Allow the user to add in any amount of text
 * This parses the text for 10- and 13-digit ISBNs
 * Those ISBNs are send to publicISBNCheck
*/
// Called when the isbn input gets a new value
function importManualOnChange(event) {
  setTimeout(function() {
    // Look at all the potential ISBNs, split by whitespace
    var values = filterISBNs($("#import_manual input").val()),
        jthinker = $("#import_manual_thinking"),
        thinker = jthinker[0],
        value, i;
    
    // Make values unique, so repeats aren't spammed
    values = getDistinctArray(values);
    
    // Don't allow repeat queries across types
    values = values.filter(importValuesNotRepeatedFilter);
    
    if(!values) return;
    for(i in values) {
      value = values[i];
      // If the value isn't an ISBN, ignore it
      if(!isValidISBN(value)) return;
      
      // Otherwise see what happens if you try to add it
      if(!thinker.thinking) thinker.thinking = 1;
      else ++thinker.thinking;
      jthinker.addClass("thinking");
      sendRequest("publicISBNCheck", {
        isbn: value
      }, importManualGetResult);
      
    }
  });
}

// Filters a text for all ISBNs
function filterISBNs(value) {
  var raws = value.replace(new RegExp('-', 'g'), "").match(/\S+/g),
      output = [],
      raw, i;
  for(i in raws) {
    raw = raws[i].replace(/\D/g,'');
    if(isValidISBN(raw)) {
      // if(raw.length == 10) {
        // output.push('978' + raw);
        // output.push('979' + raw);
      // }
      output.push(raw);
    }
  }
  return output;
}

// Only allows numbers of length 13
// (no longer accept length-10, since they may start with 0)
function isValidISBN(value) {
  return value && !isNaN(value) && (value.length == 10 || value.length == 13);
}

function importValuesNotRepeatedFilter(me) {
  if(!window.repeat_vals) {
    window.repeat_vals = [me];
    return true;
  }
  var ok = window.repeat_vals.indexOf(me) == -1;
  window.repeat_vals.push(me);
  return ok;
}

// When the PHP script finishes deciphering a potentially new ISBN
function importManualGetResult(result) {
  // If the result begins with 'Yes', remove that
  if(result.indexOf("Yes") == 0)
    result = result.substr(3);
  
  // If the result is still good, add it
  if(result && result.toLowerCase() != "no") {
    var child = document.createElement("p");
    child.innerHTML = result;
    $("#import_manual_results").prepend(child);
  }
  // Decrement the amount of known thinking
  var jthinker = $("#import_manual_thinking"),
      thinker = jthinker[0];
  --thinker.thinking;
  if(!thinker.thinking)
    jthinker.removeClass("thinking");
}

// Used to limit excessive duplicates
// http://stackoverflow.com/questions/9229645/remove-duplicates-from-javascript-array#answer-14740171
function getDistinctArray(arr) {
  var dups = {},
      hash, is_dup;
  return arr.filter(function(a) {
      hash = a.valueOf();
      is_dup = dups[hash];
      dups[hash] = true;
      return !is_dup;
  });
}

/* Automated imports
 * Specify a field and a value to search on
 * This repeatedly calls publicImportAllISBNs
*/
function importStartAutomated() {
  
}