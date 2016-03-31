<?php
// Generate a JSON file of races pulled from Strava
// Manual way: curl -G https://www.strava.com/api/v3/athlete/activities -H "Authorization: Bearer $ACCESS_TOKEN" -d per_page=100 -d page=1 >> strava.json

date_default_timezone_set('America/Los_Angeles');

const WORKOUT_TYPES = [ 0 => 'Run', 1 => 'Race', 2 => 'Long Run', 3 => 'Workout' ];

if (!isset($argv[1])) {
  exit("Please supply your Strava Access Token - find it at https://www.strava.com/settings/api\n");
} else {
  $access_token = $argv[1];
  $c = curl_init();
  $curl_page = 1;
}

$curl_url = "https://www.strava.com/api/v3/athlete/activities?per_page=200&page=";
$curl_headers = array("Authorization: Bearer $access_token");
curl_setopt($c, CURLOPT_POST, false);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
curl_setopt($c, CURLOPT_HEADER, true);
curl_setopt($c, CURLOPT_HTTPHEADER, $curl_headers);

$complete = false;
$activities = [];

while (!$complete) {
  curl_setopt($c, CURLOPT_URL, $curl_url.$curl_page);
  $response = curl_exec($c);
  $status = curl_getinfo($c, CURLINFO_HTTP_CODE); // TODO: check status = 200
  $header_size = curl_getinfo($c, CURLINFO_HEADER_SIZE);
  $header = substr($response, 0, $header_size);
  $body = substr($response, $header_size);
  $activity_page = json_decode($body);
  if (count($activity_page) > 0) {
    $activities = array_merge($activities, $activity_page);
    $curl_page++;
  } else {
    $complete = true;
  }
  echo "New Activities found: ".count($activity_page)."\n";
}
curl_close($c);

$athlete_id = $activities[0]->athlete->id;
echo "Athlete ID: $athlete_id\n";
echo "Total Activities found: ".count($activities)."\n";
$runs = [];
foreach ($activities as $k => $obj) {
  $item = [];
  $type = isset($obj->workout_type) ? WORKOUT_TYPES[$obj->workout_type] : 'Unknown';
  if ($obj->type == 'Run') {
    // $item['type'] = $type;
    $item['name'] = $obj->name;
    $item['distance'] = ""; // TODO: Guestimate based on distance_meters
    $item['distance_meters'] = $obj->distance; // meters
    $item['time'] =
    $item['time_seconds'] = $obj->elapsed_time; // seconds - moving_time better for non-races
    $item['date'] = date("Y-m-d", strtotime($obj->start_date_local));
    $item['location'] = ($obj->location_city && $obj->location_state) ? $obj->location_city . ", " . $obj->location_state : '';
    $runs[$type][] = $item;
  }
}

echo "Your Races:\n";
echo var_export($runs['Race'], true);

// TODO: Only write the file if it does not already exist?
$file_raw = 'strava_raw_'.$athlete_id.'.json';
$file_output = 'strava_output_'.$athlete_id.'.json';
file_put_contents($file_raw, json_encode($activities));
file_put_contents($file_output, json_encode($runs['Race']));
