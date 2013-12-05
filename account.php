<?php 
  require_once('php/html_helpers.php');
  page_start(array("account"));
  ensure_logged_in();
  $dbConn = getPDOQuick();
  setlocale(LC_MONETARY, 'en_US');

  function accountPrintRow($left, $right, $classleft='half', $classright='half') {
    echo '<div class="form_row ' . $classleft . ' ' . $classright . '">' . PHP_EOL;
    echo accountPrintInput($left, $classleft);
    echo accountPrintInput($right, $classright);
    echo '</div>' . PHP_EOL;
  }

  function accountPrintInput($name, $classname='half') {
    $name = preg_replace("/[^A-Za-z_]/", '', $name);
    $clean_name = str_replace("_", " ", $name);
    echo '<div class="input_holder input_' . $classname . '">' . PHP_EOL;
    if ($name == "password" || $name == "confirm_password") {
      echo '  <input name="' . $name . '" id="input_' . $name . '" type="password" class="form_input" placeholder="' . $clean_name . '" />' . PHP_EOL;
    } else {
      echo '  <input name="' . $name . '" id="input_' . $name . '" type="text" class="form_input" placeholder="' . $clean_name . '" />' . PHP_EOL;
    }
    echo '  <aside class="form_aside">' . $clean_name . '</aside>' . PHP_EOL;
    echo '</div>' . PHP_EOL;
  }

  if (isset($_POST) && isset($_POST['change']) && $_POST['change'] == "Submit") {
    
  }

  $username = $_SESSION['username'];
  $user_id = $_SESSION['user_id'];
  if(isset($_SESSION['email'])) $email = $_SESSION['email'];
  if(isset($_SESSION['major'])) $major = $_SESSION['major'];
  if(isset($_SESSION['fname']) && isset($_SESSION['lname'])) $fullname = $_SESSION['fname'] . " " . $_SESSION['lname'];

?>
  <p id="before_lists"><a id='edit' href=''>Edit your account...</a><p>
  <div id='account-info' class="width_standard main_standard body_standard" class="main_standard width_standard" style="display:none">
    <form action='account.php' method='post'>
      <?php
        //accountPrintRow('first_name', 'last_name');
        accountPrintRow('email', 'username');
        //accountPrintRow('major', 'year');
        accountPrintRow('password', 'confirm_password');
      ?>
      <input type="submit" name="change" value="Submit" />
    </form>
  </div>
  <div id="listwrapper">
    <div id="wishlist" class="booklist">
      <h3>Books you want...</h3>

      <?php

      $user_wishes = dbEntriesGet($dbConn, $user_id, "Wish");
      if (isset($user_wishes)){
        if (count($user_wishes) == 0) {
          echo "<div id='listitem' style='min-height:86px'>" . PHP_EOL;
          echo "  <p style='text-align:center; text-shadow:0 0 10px gray;margin:10px'>You have nothing on your wishlist.</p>" . PHP_EOL;
          echo "  <p style='text-align:center;margin:10px'>" . PHP_EOL;
          echo "    <a href='search.php'>Add something!</a>" . PHP_EOL;
          echo "  </p>" . PHP_EOL;
          echo "</div>" . PHP_EOL;
        } else {
          foreach ($user_wishes as $entry) {
            $isbn = $entry['isbn'];
            $book_info = dbBooksGet($dbConn, $isbn);
            $google_id = $book_info['google_id'];
            $title = $book_info['title'];
            $condition = $entry['state'];
            echo "<div id='listitem'>" . PHP_EOL;
            if (isset($google_id)) { echo "  <img src='http://bks2.books.google.com/books?id=" . $google_id . "&printsec=frontcover&img=1&zoom=1&source=gbs_api' height='86' width='53' />" . PHP_EOL; }
            else { echo "  <img src='../images/book-cover-placeholder.png' height='86' width='53' />" . PHP_EOL; }
            echo "  <p><a href='http://books.google.com/books?id=" . $google_id . "&dq=" . $isbn . "' style='color:black'>" . $title . "</a></p>" . PHP_EOL;
            echo "  <p><span id='label'>ISBN: </span>" . $isbn . "</p>" . PHP_EOL;
            echo "  <p><span id='label'>Condition: </span>" . $condition . "</p>" . PHP_EOL; 
            echo "</div>" . PHP_EOL;
          }
          echo "  <p style='text-align:center;margin-top:10px;margin-bottom:0'>" . PHP_EOL;
          echo "    <a href='search.php'>Add more...</a>" . PHP_EOL;
          echo "  </p>" . PHP_EOL;
        }
      } else {
        echo "<p>Nothing returned.</p>";
      }

      ?>

    </div>
    <div id="tradelist" class="booklist">
      <h3>Books you're trading...</h3>

      <?php

      $user_trades = dbEntriesGet($dbConn, $user_id, "Trade");
      if (isset($user_trades)){ 
        if (count($user_trades) == 0) {
        echo "<div id='listitem' style='min-height:86px'>" . PHP_EOL;
          echo "  <p style='text-align:center;text-shadow:0 0 10px gray;margin:10px;color:white'>You have nothing on your tradelist.</p>" . PHP_EOL;
          echo "  <p style='text-align:center;margin:10px;color:white'>" . PHP_EOL;
          echo "    <a href='search.php'>Add something!</a>" . PHP_EOL;
          echo "  </p>" . PHP_EOL;
          echo "</div>" . PHP_EOL;
        } else {
          foreach ($user_trades as $entry) {
            $isbn = $entry['isbn'];
            $book_info = dbBooksGet($dbConn, $isbn);
            $google_id = $book_info['google_id'];
            $title = $book_info['title'];
            $condition = $entry['state'];
            $price = $entry['price'];
            echo "<div id='listitem'>" . PHP_EOL;
            if (isset($google_id)) { echo "  <img src='http://bks2.books.google.com/books?id=" . $google_id . "&printsec=frontcover&img=1&zoom=1&source=gbs_api' height='86' width='53' />" . PHP_EOL; }
            else { echo "  <img src='../images/book-cover-placeholder.png' height='86' width='53' />" . PHP_EOL; }
            echo "  <p><a href='http://books.google.com/books?id=" . $google_id . "&dq=" . $isbn . "' style='color:black'>" . $title . "</a></p>" . PHP_EOL;
            echo "  <p><span id='label'>ISBN: </span>" . $isbn . "</p>" . PHP_EOL;
            echo "  <p><span id='label'>Condition: </span>" . $condition . "</p>" . PHP_EOL;
            echo "  <p id='price'>$" . number_format($price,2,".","") . "</p>" . PHP_EOL;
            echo "</div>" . PHP_EOL;
          }
          echo "  <p style='text-align:center;margin-top:10px;margin-bottom:0'>" . PHP_EOL;
          echo "    <a href='search.php'>Add more...</a>" . PHP_EOL;
          echo "  </p>" . PHP_EOL;
        }
      } else {
        echo "<p>Nothing returned.</p>";
      }

      ?>

    </div>
    <p id="after_lists">You can also <a href="import.php">import</a> books to our database.</p>
  </div>
  <script>
    window.onload = function() {
      var a = document.getElementById("edit");
      a.onclick = function() {
        $("#account-info").slideToggle();
        $("#edit").slideUp();
        return false;
      }
    }
  </script>

<?php page_end(); ?>