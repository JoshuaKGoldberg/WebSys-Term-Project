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
  </div>
    
<?php page_end(array('import', 'requests')); ?>