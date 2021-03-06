<?php 
  require_once('php/html_helpers.php');
  page_start(array("mainpage"));
  ensure_logged_out();
?>
    
    <!-- Section 1 (main slogan) -->
  <div id="wrapper">
    <section id="center">
      <div class="aligner">
        <div class="container">
          <div class="text">
            <h1>Find textbooks to sell and trade on your campus.</h1>
          </div>
        </div>
        <!-- Log in -->
        <div id="login_form">
          <div id="login_form_inside">
            <form onsubmit="event.preventDefault(); loginSubmit(event);">
              <input id="myusername" type='text' name='username' placeholder='username' />
              <input id="mypassword" type='password' name='password' placeholder='password' />
              <input id="logmein" type='submit' value='log me in!' />
              <input style='opacity:.14' id="forgot" type='submit' value='forgot my password' />
            </form>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Section 2 (sign up) -->
    <section id="signup">
      <div class="aligner">
        <div class="container">
          <div class="text">
            <p>By signing up for <?php echo getSiteName(); ?> you're giving yourself access to <?php echo getNumBooks(); ?> of free, for-trade, and for-discount books made available by students just like you. Best of all, it's free!</p>
            <div class="half">
              <form onsubmit="event.preventDefault(); joinSubmit();">
                <div id="hold_username" class='input_holder'>
                  <input id="username" type='text' name='username' placeholder='Username' />
                  <div class="hold_complaint"></div>
                </div>
                <div id="hold_password" class='input_holder'>
                  <input id="password" type='password' name='password' placeholder='Password' />
                  <div class="hold_complaint"></div>
                </div>
				<div id="hold_password_confirm" class = 'input_holder'>
					<input id="password_confirm" type='password' name='password_confirm' placeholder='Re-enter password' />
					<div class="hold_complaint"></div>
				</div>
                <div id="hold_email" class='input_holder'>
                  <input id="email" type='email' name='email' placeholder='Email' />
                  <div class="hold_complaint"></div>
                </div>
                <input id="submit" type='submit' value='Sign Me Up!'/>
              </form>
            </div>
            <div id="pledge" class="half justified">
              <aside>We pledge to <b>never use or distribute your personal information</b> outside of this website. This means other members will be able to see your name and send you emails - that is all. Whatever else you do is on you, buddy.</aside>
            </div>
          </div>
        </div>
    </section>
    
    <!-- Section 2 (more) -->
    <section id="more">
      <div class="aligner">
        <div class="container">
          <div class="text spaced">
            <p>A central hub for college students to trade, sell, and buy textbooks on their local campus. Create a profile and join the textbook marketplace for college students!</p>
          </div>
        </div>
    </section>
  </div>
  
<?php page_end(array("mainpage")); ?>