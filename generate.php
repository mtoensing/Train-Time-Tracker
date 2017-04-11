<?php

require_once('TrainTimeTracker.php');

$from = 'Hamburg-Langenfelde';

$result = array();
$result[] = departure_in_seconds($from, 'Sternschanze', 0);
$result[] = departure_in_seconds($from, 'Sternschanze', 1);
$result[] = departure_in_seconds($from, 'Altona', 0);
$result[] = departure_in_seconds($from, 'Altona', 1);

$json = json_encode($result, JSON_PRETTY_PRINT);
$size = file_put_contents('output/langenfelde.json', $json);
$size = file_put_contents('output/' . $from . '.json', $json);

if ($size == FALSE) {
    echo "error writing file"; die();
}

$from = 'Überseequartier';

$result = array();
$result[] = departure_in_seconds($from, 'Hamburg Jungfernstieg', 0);
$result[] = departure_in_seconds($from, 'Hamburg Jungfernstieg', 1);

$json = json_encode($result, JSON_PRETTY_PRINT);
$size = file_put_contents('output/hafencity.json', $json);
$size = file_put_contents('output/' . $from . '.json', $json);


if ($size == FALSE) {
    echo "error writing file"; die();
}

$from = 'Sternschanze';

$result = array();
$result[] = departure_in_seconds('Sternschanze', 'Hamburg-Langenfelde', 0);
$result[] = departure_in_seconds('Sternschanze', 'Hamburg-Langenfelde', 1);

$json = json_encode($result, JSON_PRETTY_PRINT);
$size = file_put_contents('output/' . $from .'.json', $json);

if ($size == FALSE) {
    echo "error writing file"; die();
}

?>
