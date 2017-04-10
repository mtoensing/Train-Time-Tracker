<?php

require_once('TrainTimeTracker.php');

$result = array();
$result[] = departure_in_seconds('Hamburg-Langenfelde', 'Sternschanze', 0);
$result[] = departure_in_seconds('Hamburg-Langenfelde', 'Sternschanze', 1);
$result[] = departure_in_seconds('Hamburg-Langenfelde', 'Altona', 0);
$result[] = departure_in_seconds('Hamburg-Langenfelde', 'Altona', 1);

$json = json_encode($result, JSON_PRETTY_PRINT);
$size = file_put_contents('output/langenfelde.json', $json);

if ($size == FALSE) {
    echo "error writing file"; die();
}

$result = array();
$result[] = departure_in_seconds('Überseequartier', 'Hamburg Jungfernstieg', 0);
$result[] = departure_in_seconds('Überseequartier', 'Hamburg Jungfernstieg', 1);
$result[] = departure_in_seconds('Hamburg Jungfernstieg', 'Hochkamp', 0);
$result[] = departure_in_seconds('Hamburg Jungfernstieg', 'Hochkamp', 1);

$json = json_encode($result, JSON_PRETTY_PRINT);
$size = file_put_contents('output/hafencity.json', $json);

if ($size == FALSE) {
    echo "error writing file"; die();
}

$result = array();
$result[] = departure_in_seconds('Sternschanze', 'Hamburg-Langenfelde', 0);
$result[] = departure_in_seconds('Sternschanze', 'Hamburg-Langenfelde', 1);

$json = json_encode($result, JSON_PRETTY_PRINT);
$size = file_put_contents('output/sternschanze.json', $json);

if ($size == FALSE) {
    echo "error writing file"; die();
}

?>
