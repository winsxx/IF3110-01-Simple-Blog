<?php

try{
   #Connect to MySQL
   $host = "localhost";
   $dbname = "simple_blog";
   $user = "root";
   $pass = "";
   $databaseHandler = new PDO("mysql:host=$host;dbname=$dbname;",$user,$pass);
   $databaseHandler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   
   #Query
   $listArticleQuery = "SELECT * FROM article ORDER BY article_id DESC";
   $queryHandler = $databaseHandler->prepare($listArticleQuery);
   $queryHandler->execute();
   
   # setting the fetch mode
   $queryHandler->setFetchMode(PDO::FETCH_ASSOC);
   
   #Close connection
   $databaseHandler = null;
}catch(PDOException $e){
   echo "Sorry, there is a problem now. Please come again later";
   file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
}

echo "<!DOCTYPE html>
<html>
<head>

<meta charset=\"utf-8\">
<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
<meta name=\"viewport\" content=\"width=device-width, initial-scale=1, maximum-scale=1\">
<meta name=\"description\" content=\"Deskripsi Blog\">
<meta name=\"author\" content=\"Judul Blog\">

<!-- Twitter Card -->
<meta name=\"twitter:card\" content=\"summary\">
<meta name=\"twitter:site\" content=\"omfgitsasalmon\">
<meta name=\"twitter:title\" content=\"Simple Blog\">
<meta name=\"twitter:description\" content=\"Deskripsi Blog\">
<meta name=\"twitter:creator\" content=\"Simple Blog\">
<meta name=\"twitter:image:src\" content=\"{{! TODO: ADD GRAVATAR URL HERE }}\">

<meta property=\"og:type\" content=\"article\">
<meta property=\"og:title\" content=\"Simple Blog\">
<meta property=\"og:description\" content=\"Deskripsi Blog\">
<meta property=\"og:image\" content=\"{{! TODO: ADD GRAVATAR URL HERE }}\">
<meta property=\"og:site_name\" content=\"Simple Blog\">

<link rel=\"stylesheet\" type=\"text/css\" href=\"assets/css/screen.css\" />
<link rel=\"shortcut icon\" type=\"image/x-icon\" href=\"img/favicon.ico\">

<!--[if lt IE 9]>
    <script src=\"http://html5shim.googlecode.com/svn/trunk/html5.js\"></script>
<![endif]-->

<title>Simple Blog</title>


</head>

<body class=\"default\">
<div class=\"wrapper\">

<nav class=\"nav\">
    <a style=\"border:none;\" id=\"logo\" href=\"index.php\"><h1>Simple<span>-</span>Blog</h1></a>
    <ul class=\"nav-primary\">
        <li><a href=\"new_post.html\">+ Tambah Post</a></li>
    </ul>
</nav>

<div id=\"home\">
    <div class=\"posts\">
        <nav class=\"art-list\">
          <ul class=\"art-list-body\">";

#write all post
while($article = $queryHandler->fetch()){
   echo "           <li class=\"art-list-item\">
                <div class=\"art-list-item-title-and-time\">
                    <h2 class=\"art-list-title\"><a href=\"post.php?id=$article[article_id]\">$article[article_title]</a></h2>
                    <div class=\"art-list-time\">";
   echo date("j F Y",strtotime($article['article_date']));
   echo"</div>
                </div>
                <p>";
   $panjang = strlen($article['article_content']);
   if($panjang>300){
      echo substr($article['article_content'],0,250); 
      echo "&hellip;";
   } else{
      echo $article['article_content'];
   }
   echo"
   </p>
                <p>
                  <a href=\"update_post.php?update_id=$article[article_id]\">Edit</a> | <a href=\"delete_post_database.php?delete_id=$article[article_id]\" onclick=\"return deleteConfirm()\">Hapus</a>
                </p>
            </li>";
}

echo "         </ul>
        </nav>
    </div>
</div>

<footer class=\"footer\">
    <div class=\"back-to-top\"><a href=\"\">Back to top</a></div>
    <!-- <div class=\"footer-nav\"><p></p></div> -->
    <div class=\"psi\">&Psi;</div>
    <aside class=\"offsite-links\">
        Asisten IF3110 /
        <a class=\"rss-link\" href=\"#rss\">RSS</a> /
        <br>
        <a class=\"twitter-link\" href=\"http://twitter.com/YoGiiSinaga\">Yogi</a> /
        <a class=\"twitter-link\" href=\"http://twitter.com/sonnylazuardi\">Sonny</a> /
        <a class=\"twitter-link\" href=\"http://twitter.com/fathanpranaya\">Fathan</a> /
        <br>
        <a class=\"twitter-link\" href=\"#\">Renusa</a> /
        <a class=\"twitter-link\" href=\"#\">Kelvin</a> /
        <a class=\"twitter-link\" href=\"#\">Yanuar</a> /
        
    </aside>
</footer>

</div>

<script type=\"text/javascript\" src=\"assets/js/fittext.js\"></script>
<script type=\"text/javascript\" src=\"assets/js/app.js\"></script>
<script type=\"text/javascript\" src=\"assets/js/respond.min.js\"></script>
<script type=\"text/javascript\" src=\"assets/js/validator.js\"></script>
<script type=\"text/javascript\">
  var ga_ua = '{{! TODO: ADD GOOGLE ANALYTICS UA HERE }}';

  (function(g,h,o,s,t,z){g.GoogleAnalyticsObject=s;g[s]||(g[s]=
      function(){(g[s].q=g[s].q||[]).push(arguments)});g[s].s=+new Date;
      t=h.createElement(o);z=h.getElementsByTagName(o)[0];
      t.src='//www.google-analytics.com/analytics.js';
      z.parentNode.insertBefore(t,z)}(window,document,'script','ga'));
      ga('create',ga_ua);ga('send','pageview');
</script>

</body>
</html>";

?>