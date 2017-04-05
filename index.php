<?php

/* display real time information for a specific connection by scraping mobile.bahn.de */

require_once("simple_html_dom.php");

function url_to_dom($href, $to = '', $from = '') {
  $post = false;
  if($to && $from){
    $date = date('d.m.y');
    $time = date('H:i');
    // set post fields
    $post = [
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
      'existOptimizePrice' => 1,
      'REQ0HafasOptimize1' => '0:1',
      'rtMode' => 12,
      'existRTMode' => 1,
      'immediateAvail' => 'ON',
      'start' => 'Suchen'
    ];
  }

    $curl = curl_init();
    if($post){
      curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
      curl_setopt($curl, CURLOPT_POST, true);
    }
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_URL, $href);
    curl_setopt($curl, CURLOPT_REFERER, $href);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_COOKIEJAR, 'cookies.txt');
    curl_setopt($curl, CURLOPT_COOKIEFILE, 'cookies.txt');
    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/533.4 (KHTML, like Gecko) Chrome/5.0.375.125 Safari/533.4");
    $str = curl_exec($curl);
    curl_close($curl);

    // Create a DOM object
    $dom = new simple_html_dom();
    // Load HTML from a string
    $dom->load($str);

    return $dom;
}





function departure_in_seconds($from, $to, $connection_number){
      $hp = 'https://mobile.bahn.de/bin/mobil/query.exe/dox?country=DEU&rt=1&use_realtime_filter=1&webview=&searchMode=NORMAL&sotRequest=1';
      $html = url_to_dom($hp);
      // get action url
      $row_number = ($connection_number+1) * 2 - 2;

      $actionurl =  $html->find('form',0)->action;

      $html = url_to_dom($actionurl, $from, $to);

//echo $html;die();
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
