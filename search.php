<?php 
  require_once('php/html_helpers.php');
  page_start(array('search_full', 'books'));
  
  function searchPrintRow($left, $right, $classleft='half', $classright='half') {
    echo '<div class="search_form_row search_' . $classleft . ' search_' . $classright . '">' . PHP_EOL;
    echo searchPrintInput($left, $classleft);
    echo searchPrintInput($right, $classright);
    echo '</div>' . PHP_EOL;
  }
  
  function searchPrintInput($name, $classname='half') {
    $name = preg_replace("/[^A-Za-z]/", '', $name);
    echo '<div class="search_input_holder search_input_' . $classname . '">' . PHP_EOL;
    echo '  <input onchange="searchFull();" id="search_input_' . $name . '" type="text" placeholder="' . $name . '" />' . PHP_EOL;
    echo '  <aside>' . $name . '</aside>' . PHP_EOL;
    echo '</div>' . PHP_EOL;
  }
?>
  
  <div class="width_standard main_standard body_standard" class="main_standard width_standard">
    
    <h1>Search through a curated database of <?php echo getNumBooks(); ?> of books submitted by you and other students at RPI.</h1>
  
    <!-- The form itself -->
    <form id="search_form" onkeydown="searchFull();" action="event.preventDefault();">
      <?php
        searchPrintRow('title', 'author(s)');
        searchPrintRow('description', 'year', 'two-thirds', 'one-third');
        searchPrintRow('isbn', 'publisher');
      ?>
    </form>

    <!-- Results will be displayed here -->
    <div id="search_form_results"></div>
  </div>
    
<?php page_end(array('search_full', 'books')); ?>

<!-- Auto-start the search -->
<script type='text/javascript'> searchFullResults(); </script>
