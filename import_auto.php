<?php 
  require_once('php/html_helpers.php');
  page_start());
  ensure_logged_in();
?>

<div class="main_standard width_standard">
  <h2>Loading book records from Fall 2013...</h2>
  <div id="imports_holder"></div>
</div>
    
<?php page_end(array('import', 'requests')); ?>
<script type="text/javascript">importStart();</script>