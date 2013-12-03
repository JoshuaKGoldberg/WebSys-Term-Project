<!DOCTYPE html>
<html>
<head>
    <!--It'd be cool if we could replace the title with the user's name later-->
    <title>Profile</title>
    <link href='http://fonts.googleapis.com/css?family=Doppio+One' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.3.0/pure-min.css">
    <link rel="stylesheet" type="text/css" href="css/profilepage.css">
</head>
<body>
    <div id="badge">
        <img src="images/profile-photo-placeholder.jpg" alt="" height="60" width="60">
        <p>Name</p>
        <p>Major/Year</p>
        <p>Email</p>
    </div>
    <header>
        <h1><a href="index.php">book exchange or something idk</a></h1>
    </header>
    <form class="pure-form" id="search">
        <input type="search" placeholder="Search">
        <button type="submit" class="pure-button">Search</button>
    </form>
    <div id="listwrapper">
        <section id="wishlist" class="booklist">
            <h3>Books you want:</h3>
                <div id="listitem">
                    <!-- i will write up a PHP snippet that will iterate through the database and
                         make an entry for each book in the list -->
                    <img src="images/book-cover-placeholder.png" height="86" width="86">
                    <p>Title</p>
                    <p>ISBN</p>
                </div>
        </section>
        <section id="tradelist" class="booklist">
            <h3>Books you're trading:</h3>
                <div id="listitem">
                    <!-- i will write up a PHP snippet that will iterate through the database and
                         make an entry for each book in the list -->
                    <img src="images/book-cover-placeholder.png" height="86" width="86">
                    <p>Title</p>
                    <p>ISBN</p>
                </div>
        </section>
    </div>


    <footer>
      (WebSys term project)
      <hr />
      haters gonna hate
    </footer>
</body>
</html>