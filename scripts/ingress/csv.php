<?php
/**
 * Utility script to import a csv file with:
 *
 * Required headers:
 *   name
 *   date
 *   distance (as in 5k, 1 mile, half-marathon, etc.)
 *   time (race performance in hh:mm:ss)
 *
 * Optional headers:
 *   type (as in track, road, cross country, trail, etc.)
 *   location
 *   pace
 *   splits
 *   notes
 */
ini_set('auto_detect_line_endings', true);
date_default_timezone_set('America/Los_Angeles');

if (!isset($argv[1])) {
  exit("Please choose the csv file you wish to parse\n");
} else {
  $csv_file = $argv[1];
}

if (file_exists($csv_file)) {
  $rows = file($csv_file);
} else {
  throw new InvalidArgumentException("File not found or failed failed to open: $csv_file");
}

$races_arr = array();
$col_names = array();
foreach ($rows as $n => $row) {
  $arr = str_getcsv($row);
  if (empty($col_names)) {
    $col_names = $arr;
  } else {
    $line = array();
    foreach ($arr as $i => $val) {
      $line[$col_names[$i]] = $val;
    }
    // Clean up data & fill in the blank
    if (!isset($line['distance_meters']) || empty($line['distance_meters'])) {
      $line['distance_meters'] = convertDistanceToMeters($line['distance']);
    }
    if (!isset($line['time_seconds']) || empty($line['time_seconds'])) {
      $line['time_seconds'] = convertTimeToSeconds($line['time']);
    }
    $line['date'] = cleanupDate($line['date']);
    $line['pace'] = formatPace($line['time_seconds'], $line['distance_meters']);

    $races_arr[] = $line;
  }
}

// var_dump($races_arr); // debug

$json_file = explode(".", $csv_file)[0].'.json';
if (!file_exists($json_file)) {
  $json_fh = fopen($json_file, 'w');
  fwrite($json_fh, json_encode($races_arr));
  echo count($races_arr)." lines written to $json_file\n";
} else {
  throw new InvalidArgumentException("JSON output file already exists: $json_file.");
}

function cleanupDate($input) {
  return date('Y-m-d', strtotime($input));
}

// We will use this to convert lowercase to meters
function convertDistanceToMeters($input) {
  $simple = str_replace(array(" ", "-", "_"), "", trim(strtolower($input)));
  // TODO: make this smarter and do a regexp to detect Xmiles, Ymeters, Zkilometers, etc.
  $meter_conversion_map = array(
                  "800meters" => 800.0,
                  "1500meters" => 1500.0,
                  "1600meters" => 1600.0,
                  "1mile" => 1609.34,
                  "3200meters" => 3200.0,
                  "2miles" => 3218.68,
                  "3miles" => 4828.02,
                  "5k" => 5000.0,
                  "8k" => 8000.0,
                  "5miles" => 8046.72,
                  "10k" => 10000.0,
                  "10miles" => 16093.4,
                  "20k" => 20000,
                  "halfmarathon" => 21082.41,
                  "25k" => 25000,
                  "30k" => 30000,
                  "marathon" => 42164.81,
                  "50k" => 50000.0
                );
  if (isset($meter_conversion_map[$simple])) {
    return $meter_conversion_map[$simple];
  } else {
    throw new InvalidArgumentException("We could not figure out the distance in meters for $input. Please fill in the distance_meters column with distance converted to meters");
  }
}

function convertTimeToSeconds($time_str) {
  $tmp = explode(":", $time_str);
  if (count($tmp) == 3) {
    list($h, $m, $s) = $tmp;
  } else if (count($tmp) == 2) {
    $h = 0;
    list($m, $s) = $tmp;
  } else {
    // TODO: Check this with a regex first
    throw new InvalidArgumentException("The time must be in format hh:mm:ss or h:mm:ss or mm:ss");
  }
  $time_in_seconds = ($h * 3600) + ($m * 60) + ($s);
  return $time_in_seconds;
}

/**
 * @param int $time time in seconds
 * @param int $distance distance in meters
 * @param string $type output type
 *
 * @return float
 */
function calculatePace($time, $distance, $type = 'minutes_per_mile') {
  switch ($type) {
    case 'minutes_per_mile' :
      $factor = 26.82233;
      break;
    case 'minutes_per_km' :
      $factor = 16.66667;
      break;
    case 'seconds_per_meter' :
      $factor = 1;
      break;
    default :
      throw new InvalidArgumentException("Unknown output type: ".$type);
  }
  return ($time / $distance) * $factor;
}

function formatPace($time, $distance, $type = 'minutes_per_mile', $show_units = false) {
  $pace = calculatePace($time, $distance, $type);
  switch ($type) {
    case 'minutes_per_mile' :
      $min = floor($pace);
      $sec = ($pace - $min) * 60;
      $output = $min.':'.str_pad((string) round($sec, 1), 4, "0", STR_PAD_LEFT);
      $output .= $show_units ? ' minutes per mile' : '';
      break;
    case 'minutes_per_km' :
      $min = floor($pace);
      $sec = ($pace - $min) * 60;
      $output = $min.':'.str_pad((string) round($sec, 1), 4, "0", STR_PAD_LEFT);
      $output .= $show_units ? ' minutes per kilometer' : '';
      break;
    case 'seconds_per_meter' :
      $output = round($pace, 3);
      $output .= $show_units ? ' seconds per meter' : '';
      break;
  }
  return $output;
}
