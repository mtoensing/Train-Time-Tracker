<!doctype html>
<html>
<?php

$do_not_load = false;

if(!isset($_GET['id']) && empty($_GET['id'])){
    $do_not_load = true;
}

?>
<head>
    <!--

    Grüße an alle Quelltext-Leser!

    Besuche https://marc.tv


    URL zu diesem Projekt: https://github.com/mtoensing/3T

    -->
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale = 1.0,maximum-scale = 1.0"/>
    <link rel="apple-touch-icon" href="ios/AppIcon.appiconset/Icon-60@2x.png"/>
    <link rel="apple-touch-icon" sizes="180x180" href="ios/AppIcon.appiconset/Icon-60@3x.png"/>
    <link rel="apple-touch-icon" sizes="76x76" href="ios/AppIcon.appiconset/Icon-76.png"/>
    <link rel="apple-touch-icon" sizes="152x152" href="ios/AppIcon.appiconset/Icon-76@2x.png"/>
    <link rel="apple-touch-icon" sizes="58x58" href="ios/AppIcon.appiconset/Icon-Small@2x.png"/>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>Train Time Tracker</title>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
    <?php if($do_not_load == false) { ?>
    <script src="js/jquery.countdown.js?v=2"></script>
    <script src="js/jquery.init.js?v=2"></script>
    <?php } ?>
    <link rel="stylesheet" type="text/css" href="css/styles.css?v=2" media="all"/>
    <link href="https://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet">
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-4146440-7', 'auto');
        ga('send', 'pageview');

    </script>
</head>
<body>
<?php
$path_to_output = str_replace('index.php','',__FILE__).'output';
echo '<ul>';
if($do_not_load == true){
    $files = glob($path_to_output.'/*.json');
    foreach ($files as $path) {
        $json = str_replace($path_to_output.'/','',$path);
        $id = str_replace('.json','',$json);

        echo '<li><a href="?id='. $id .'">'. $id .'</a></li>';
    }
}
echo '</ul>';



?>
</body>
</html>
