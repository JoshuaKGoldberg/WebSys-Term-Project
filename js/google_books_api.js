/* Handlers for the Google Books API v1
 * https://developers.google.com/books/docs/v1/using
*/

// Attempts to add a book to the database
function addBookISBN(isbn) {
  sendRequest("publicAddBook", {
    "isbn": isbn,
  }, getAddBookResult);
}
function getAddBookResult() {
  console.log(arguments[0]);
}