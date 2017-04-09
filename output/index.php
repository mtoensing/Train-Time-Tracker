<?php


if (array_key_exists('callback', $_GET)) {

    header('Content-Type: text/javascript; charset=utf8');
    header('Access-Control-Max-Age: 3628800');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

    $identifier = $_GET['id'];

    if ($identifier) {

        $data = file_get_contents($identifier . ".json"); // json string
        $callback = $_GET['callback'];
        echo $callback . '(' . $data . ');';

    } else {

        echo '[{
        "from": "Error",
        "to": "Error",
        "departure_time_in_seconds": 0,
        "departure_time_in_minutes": "00:00",
        "departure_countdown_time": "",
        "trainline": "ERROR"}]';
    }

} else {
    // normal JSON string
    header('Content-Type: application/json; charset=utf8');

    echo $data;
}
