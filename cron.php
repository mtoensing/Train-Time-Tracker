<?php

$link_to_this_file = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$link_to_generator = str_replace("cron.php","",$link_to_this_file);

file_put_contents("time2train.json", fopen($link_to_generator.'time2train.php', 'r'));
?>
