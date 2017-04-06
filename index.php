<?php

/* Display real time information for a specific connection by scrapping mobile.bahn.de */

require_once("simple_html_dom.php");

function departure_in_seconds($from, $to, $connection_number){

      // html on mobile.bahn.de is weird. So wi
      $row_number = ($connection_number+1) * 2 - 2;

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

      /* post form fields to mobile.bahn.de */
      $html = url_to_dom('https://mobile.bahn.de/bin/mobil/query.exe/dox', $post);

      /* Scrape the correct train connection from HTML */
      $connection = str_get_html($html->find('.scheduledCon',$row_number));

      /* Find departure time information in connection HTML snippet */
      $departure_time_string = $connection->find('.bold',0)->plaintext;

      /* Find delay information in connection HTML snippet */
      $delay_string =  $connection->find('.okmsg',0);
      $delay = preg_replace("/[^0-9]/","",$delay_string);
      $delay_seconds = $delay*60;

      /* Calculate the time until departure in seconds. */
      $departure_in_seconds = strtotime($departure_time_string) + $delay_seconds - strtotime('now');


      /* Find link to train connection detail information page */
      $connection_details_url = ($connection->find('a',0)->href);

      /* Scrape this connection detail url */
      $connection_details_html = url_to_dom($connection_details_url);

      /* Find the trainline in the HTML snippet */
      $trainline = $connection_details_html->find('.motSection',0);

      /* Return all information */
      return $departure_time_string.' Delay:'.$delay.' Train line:'.$trainline;

}

function url_to_dom($href, $post = false) {

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_COOKIEFILE, 'cookies.txt');
    curl_setopt($curl, CURLOPT_COOKIEJAR, 'cookies.txt');

    if( $post ){
      curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
      curl_setopt($curl, CURLOPT_POST, true);
    }
        curl_setopt($curl, CURLOPT_URL, $href);

    $str = curl_exec($curl);
    curl_close($curl);
    // Create a DOM object
    $dom = new simple_html_dom();
    // Load HTML from a string
    $dom->load($str);

    return $dom;
}

echo departure_in_seconds('Langenfelde', 'Altona', 0).'<br>';
//echo departure_in_seconds('Langenfelde', 'Altona', 1).'<br><br>';
//echo departure_in_seconds('Langenfelde', 'Sternschanze', 0).'<br>';
//echo departure_in_seconds('Langenfelde', 'Sternschanze', 1);
