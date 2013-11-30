<?php
  require_once('settings.php');
  require_once('html_help.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Book Exchange</title>
    <link rel="stylesheet" type="text/css" href="default.css">
    <link href='http://fonts.googleapis.com/css?family=Doppio+One' rel='stylesheet' type='text/css'>
    </head>
  <body>
    <!-- Header -->
    <header>
      <h1>book exchange or something idk</h1>
    </header>
    
    <!-- Section 1 (main slogan) -->
    <section id="center">
      <div class="aligner">
        <div class="container">
          <div class="text">
            <h1>Find textbooks to sell and trade, on your campus.</h1>
          </div>
        </div>
      
        <!-- Sign up / Log in -->
        <div id="button">
          <div id="button_inside">
            <div class="half" onclick="scrollToSection('signup')">join!</div>
            <div class="half">log in</div>
              <!--
                <input type='text' value='username' name='username' />
                <input type='text' value='password' name='password' />
                <input type='submit' value='log in' />
              -->
          </div>
        </div>
      </div>
    
    </section>
    
    <!-- Section 2 (sign up) -->
    <section id="signup">
      <div class="aligner">
        <div class="container">
          <div class="text">
            <p>By signing up for 'book exchange or something idk' you're giving yourself access to 'some number' of free, for-trade, and for-discount books made available by students just like you. It's free to join, you might as well sign.</p>
            <div class="half">
              <form onsubmit="return joinSubmit()">
                <div id="hold_username" class='input_holder'>
                  <input id="username" type='text' name='username' placeholder='username' />
                  <aside>username</aside>
                  <div class="hold_complaint"></div>
                </div>
                <div id="hold_password" class='input_holder'>
                  <input id="password" type='text' name='password' placeholder='password' />
                  <aside>password</aside>
                  <div class="hold_complaint"></div>
                </div>
                <div id="hold_email" class='input_holder'>
                  <input id="email" type='email' name='email' placeholder='email@address' />
                  <aside>email</aside>
                  <div class="hold_complaint"></div>
                </div>
                <input type='submit' value='Sign Me Up!'/>
              </form>
            </div>
            <div id="pledge" class="half justified">
              <aside>We pledge to <b>never use or distribute your personal information</b> outside of this website. This means other members will be able to see your name and send you private messages on this site - that is all. Whatever else you do is on you, buddy.</aside>
            </div>
          </div>
        </div>
    </section>
    
    <!-- Section 2 (more) -->
    <section id="more">
      <div class="aligner">
        <div class="container">
          <div class="text">
            <p>More information on what the site does, explanation of the term project, etc? maybe</p>
          </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer>
      (WebSys term project)
      <hr />
      haters gonna hate
    </footer>
  </body>
  
  <script type="text/javascript" src="jquery-2.0.3.min.js"></script>
  <script type="text/javascript" src="mainpage.js"></script>
</html>