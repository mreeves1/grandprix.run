<?php
// Generate a JSON file of races pulled from Athlinks
// Manual way: curl "https://www.athlinks.com/Athletes/Api/$ATHLETE_ID/Races?include_legs=false" >> athlinks.json 
 
// const WORKOUT_TYPE_TYPES = [ 0 => 'Run', 1 => 'Race', 2 => 'Long Run', 3 => 'Workout' ];

if (!isset($argv[1])) {
  exit("Please supply your Athlinks Athlete ID - find it at your logged in home page at https://www.athlinks.com/athletes/\$ATHLETE_ID \n");
} else {
  $athlete_id = $argv[1];
  $c = curl_init();
}

$curl_url = "https://www.athlinks.com/Athletes/Api/$athlete_id/Races?include_legs=false";
curl_setopt($c, CURLOPT_POST, false);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
curl_setopt($c, CURLOPT_HEADER, true);
// curl_setopt($c, CURLOPT_HTTPHEADER, $curl_headers);
curl_setopt($c, CURLOPT_URL, $curl_url);
$response = curl_exec($c);
$status = curl_getinfo($c, CURLINFO_HTTP_CODE); // TODO: check status = 200
$header_size = curl_getinfo($c, CURLINFO_HEADER_SIZE);
$header = substr($response, 0, $header_size);
$body = substr($response, $header_size);
$resp_obj = json_decode($body);
curl_close($c);

echo "Athlete ID: $athlete_id\n";
echo "Total Activities found: ".count($resp_obj->Result->raceEntries->List)."\n";
$races = [];
foreach ($resp_obj->Result->raceEntries->List as $k => $obj) {
  $item = [];
  // $item['type'] = $type;
  $item['name'] = $obj->Race->RaceName." - ".$obj->Race->Courses[0]->CourseName;
  $item['distance'] = $obj->Race->Courses[0]->DistUnit; // meters
  $item['time'] = $obj->Ticks / 1000; // seconds - moving_time better for non-races
  $item['start'] = $obj->Race->RaceDate;
  $item['location'] = ($obj->Race->City && $obj->Race->StateProvAbbrev) ? $obj->Race->City . ", " . $obj->Race->StateProvAbbrev : '';
  $races[] = $item;
}

echo "Your Races:\n";
echo var_export($races, true);

$file_raw = 'athlinks_raw_'.$athlete_id.'.json';
$file_output = 'athlinks_output_'.$athlete_id.'.json';
file_put_contents($file_raw, json_encode($resp_obj));
file_put_contents($file_output, json_encode($races));
