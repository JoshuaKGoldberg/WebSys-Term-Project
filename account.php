<?php 
  require_once('php/html_helpers.php');
  page_start(array("account"));
  ensure_logged_in();

  $username = $_SESSION['username'];
  $user_id = $_SESSION['user_id'];
  if(isset($_SESSION['email'])) $email = $_SESSION['email'];
  if(isset($_SESSION['major'])) $major = $_SESSION['major'];
  if(isset($_SESSION['fname']) && isset($_SESSION['lname'])) $name = $_SESSION['fname'] . " " . $_SESSION['lname'];

  $dbConn = getPDOQuick();
?>

  <div id="listwrapper">
    <div id="wishlist" class="booklist">
      <h3>Wishlist</h3>
      <?php

      $user_wishes = dbEntriesGet($dbConn, $user_id, "Wish");
      if (isset($user_wishes)){ 
        if (count($user_wishes) == 0) {
          echo "<div id='listitem'>
                  <p style='text-align:center; text-shadow:0 0 10px gray'>You have nothing on your wishlist.</p>
                  <p style='text-align:center'>
                    <a href=''>Add something!</a>
                  </p>
                </div>";
        } else {
          foreach ($user_wishes as $book) {
            # code...

            //<img src="../images/book-cover-placeholder.png" height="86" width="86">
            //<p>Title</p>
            //<p>ISBN</p>
          }
        }
      } else {
        echo "<p>Nothing returned.</p>";
      }

      ?>
    </div>
    <div id="tradelist" class="booklist">
      <h3>Tradelist</h3>
      <?php

      $user_trades = dbEntriesGet($dbConn, $user_id, "Trade");
      if (isset($user_trades)){ 
        if (count($user_trades) == 0) {
        echo "<div id='listitem'>
                <p style='text-align:center; text-shadow:0 0 10px gray'>You have nothing on your tradelist.</p>
                <p style='text-align:center'>
                  <a href=''>Add something!</a>
                </p>
              </div>";
        } else {
          foreach ($user_trades as $book) {
            # code...

            //<img src="../images/book-cover-placeholder.png" height="86" width="86">
            //<p>Title</p>
            //<p>ISBN</p>
          }
        }
      } else {
        echo "<p>Nothing returned.</p>";
      }

      ?>
    </div>
    <p id="after_lists">You can also <a href="import.php">import</a> books to our database.</p>
  </div>

<?php page_end(); ?>