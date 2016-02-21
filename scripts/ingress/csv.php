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

date_default_timezone_set('America/Los_Angeles');

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
}