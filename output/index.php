<?php
error_reporting(E_ERROR);

function listJSON()
{
    $path_to_output_dir = str_replace('index.php', '', __FILE__);


    $files = glob($path_to_output_dir . '/*.json');
    $html = '';

    foreach ($files as $path) {
        $json = str_replace($path_to_output_dir . '/', '', $path);
        $id = str_replace('.json', '', $json);
        $html .= '<li><a href="?id=' . $id . '">' . $id . '</a></li>';
    }

    return $html;
}

if (array_key_exists('callback', $_GET)) {

    header('Content-Type: text/javascript; charset=utf8');
    header('Access-Control-Max-Age: 3628800');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

    $identifier = $_GET['id'];


    $data = file_get_contents($identifier . ".json"); // json string
    $callback = $_GET['callback'];

    if ($data == false) {
        $output = Array(
            "html" => listJSON()
        );

        echo $callback . '(' . json_encode($output, JSON_PRETTY_PRINT) . ');';

    } else {

        echo $callback . '(' . $data . ');';
    }
}


