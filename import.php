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
    
    <?php // if($_SESSION['role'] == '1'): ?>
      <!-- Since the user is an administrator, display the automated import options -->
      <aside id='import_auto_aside'>Alternately, since you're an administrator, you can auto-import from the Google API.</aside>
      <form id='import_auto_form' action="event.preventDefault(); ">
        When
        <select id='import_auto_field'>
        
        </select>
        contains
        <select id='import_auto_value'>
        
        </select>
        <input id='import_auto_submit' type='button' value='Import!' />
      </form>
    <?php // endif ?>
    
  </div>
    
<?php page_end(array('import', 'requests')); ?>