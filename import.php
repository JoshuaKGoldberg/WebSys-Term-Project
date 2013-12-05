<?php 
  require_once('php/html_helpers.php');
  page_start(array('import'));
  ensure_logged_in();
?>

  <div class='width_standard main_standard body_standard'>
    
    <h1 id='import_manual_label'>Give us the ISBN, and we'll do the rest.</h1>
    <div id='import_manual'>
      <input oninput="importManualOnChange(event);" type='text' placeholder='ISBN(s)' />
    </div>

    <div id='import_manual_thinking'>hmm...</div>
    <p id='import_manual_results' class='main_standard'></p>
    
    <?php if(isset($_GET['hint'])) : ?>
      <div id='import_manual_hint'>
        <!--<aside>A few smaller places to start might be...</aside>
        <ul>
           <li><a href="http://www.folger.edu/template.cfm?cid=1339">Shakespeare's Works</a></li>
        </ul>-->
        <aside>You might want to read <a href="http://www.quora.com/ISBN-Numbers/Where-can-I-find-a-list-of-ISBNs-for-all-of-the-books-published-over-the-last-5-or-10-years">this</a>.</aside>
      </div>
    <?php endif ?>
    
  </div>
    
<?php page_end(array('import', 'requests')); ?>