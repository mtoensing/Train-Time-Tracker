<?php

$start = microtime(true);


/*prevent DOS attack */
if (isset($_GET['secret']) && $_GET['secret'] == '31337') {
    
    require_once('TrainTimeTracker.php');

    generateJSON('Hamburg-Langenfelde', 'Sternschanze');

    generateJSON('Hamburg-Langenfelde', 'Altona');

    generateJSON('Überseequartier', 'Hamburg Jungfernstieg');

    generateJSON('Sternschanze', 'Hamburg-Langenfelde');

}
$end = microtime(true);
echo 'script execution time in seconds: ' . round($end - $start, 2);

?>
