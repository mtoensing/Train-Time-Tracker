<?php

/* display real time information for a specific connection by scrapping mobile.bahn.de */

require_once("simple_html_dom.php");




function departure_in_seconds($from, $to, $connection_number){
      $hp = 'https://mobile.bahn.de/bin/mobil/query.exe/dox?country=DEU&rt=1&use_realtime_filter=1&webview=&searchMode=NORMAL&sotRequest=1';
      $html = file_get_html($hp);
      // get action url
      $row_number = ($connection_number+1) * 2 - 2;

      $actionurl =  $html->find('form',0)->action;

      $date = date('d.m.y');
      $time = date('H:i');

      $options = array(
        'http'=>array(
          'method'=>"POST",
          'content' => http_build_query(array(
              'queryPageDisplayed' => 'yes',
              'REQ0JourneyStopsS0A'=> 1,
              'REQ0JourneyStopsS0G' => $from,
              'REQ0JourneyStopsS0ID' => '',
              'locationErrorShownfrom' => 'yes',
              'REQ0JourneyStopsZ0A' => 1,
              'REQ0JourneyStopsZ0G' => $to,
              'REQ0JourneyStopsZ0ID' => '',
              'locationErrorShownto' => 'yes',
              'REQ0JourneyDate' => $date,
              'REQ0JourneyTime' => $time,
              'existOptimizePrice' => '1',
              'REQ0HafasOptimize1' => ':0:1',
              'rtMode' => '12',
              'existRTMode' => '1',
              'immediateAvail' => 'ON',
              'start' => 'Suchen'
          )),
          'header'=>"Accept-language: en\r\n" .
                    "Cookie: foo=bar\r\n" .  // check function.stream-context-create on php.net
                    "Content-Type: text/html\r\n" .
                    "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n" // i.e. An iPad
        )
      );

      $context = stream_context_create($options);
      $html = file_get_html($actionurl, false, $context);

//echo $html;
      $connection = str_get_html($html->find('.scheduledCon',$row_number));

      $departure_time_string = $connection->find('.bold',0)->plaintext;

      $delay_string =  $connection->find('.okmsg',0);
      $delay = preg_replace("/[^0-9]/","",$delay_string);
      $delay_seconds = $delay*60;

      $departure_in_seconds = strtotime($departure_time_string) + $delay_seconds - strtotime('now');

      $connection_details_url = $connection->find('a',0)->href;


/* get line */

$options = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Accept-language: en\r\n" .
              "Cookie: foo=bar\r\n" .  // check function.stream-context-create on php.net
              "Content-Type: text/html\r\n" .
              "User-Agent: Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.102011-10-16 20:23:10\r\n" // i.e. An iPad
  )
);
      $context = stream_context_create($options);
      $connection_details_html = file_get_html($connection_details_url, false, $context);
      $line = $connection_details_html->find('.motSection',0);



      return $departure_time_string.' Delay:'.$delay.' Line:'.$line;

}

echo departure_in_seconds('Langenfelde', 'Altona', 0).'<br>';
echo departure_in_seconds('Langenfelde', 'Altona', 1).'<br><br>';
echo departure_in_seconds('Langenfelde', 'Sternschanze', 0).'<br>';
echo departure_in_seconds('Langenfelde', 'Sternschanze', 1);
