<?php
$num_albums = 5;
$scene = $_GET["scene"];
$player= $_GET["player"];
$current_hour = date('H');

require("./config.php");
require("./squeeze_functions.php");
$player_id = $player_ids[$player];

if ($scene == "stop") {
   squeezebox_stop($server,$player_id);
   exit;
}


if ($scene == "setvolume"){

  if(isset($_GET["volume"])) {
  $vol = $_GET["volume"];
  file_get_contents("http://192.168.1.11:9000/anyurl?p0=mixer&p1=volume&p2=$vol&player=$player_id");
  }
 exit;
}


$vol = $scenes[$scene]["volume_level"];

if(isset($_GET["volume"])) {
  $vol = $_GET["volume"];
}

if(isset($scenes[$scene]["notbefore_hour"]) and isset($scenes[$scene]["notafter_hour"]) and $_GET["ignore_time"] != "true") {
  if ($current_hour < $scenes[$scene]["notbefore_hour"] and $current_hour > $scenes[$scene]["notafter_hour"]) {
      print "Outside time boundry for scene";
      exit;
  }
}

if(isset($scenes[$scene]["run_if_playing"]) and $scenes[$scene]["run_if_playing"] == false){
  if (squeezebox_is_playing($server,$player_id)) { 
    print "Scene will not interrupt current music. ";
    print "Reset volume to $vol.";
    file_get_contents("http://192.168.1.11:9000/anyurl?p0=mixer&p1=volume&p2=$vol&player=$player_id");
    exit;
  } 
}

$music_list_filename = $scenes[$scene]["music_list"];
$album_paths = array();
$track_paths = array();

$music_list_file = fopen($music_list_filename,"r") or die("cannot open file");
while(!feof($music_list_file)) {
  $path = fgets($music_list_file);
  if ($path != ""){
    array_push($album_paths, $path);
  }
}
fclose($music_list_file);

if(isset($scenes[$scene]["track_list"])) {
   $track_list_filename = $scenes[$scene]["track_list"];
   $track_list_file = fopen($track_list_filename,"r") or die("cannot open file");
   
  while(!feof($track_list_file)) {
  $path = fgets($track_list_file);
  if ($path != ""){
    array_push($track_paths, $path);
  }}
}


file_get_contents("http://192.168.1.11:9000/anyurl?p0=stop&player=$player_id");
file_get_contents("http://192.168.1.11:9000/anyurl?p0=mixer&p1=volume&p2=$vol&player=$player_id");
file_get_contents("http://192.168.1.11:9000/anyurl?p0=playlist&p1=clear&player=$player_id");

print_r($album_paths);

print_r($track_paths);

print "<br / > <br />";
insert_track_chance(10);
while($num_albums > 0 and sizeof($album_paths) >0 ){
   $index =  mt_rand(0,sizeof($album_paths)-1);
   $path = $album_paths[$index];
   print "Adding album $path <br / >";
   squeezebox_enqueue($server,$player_id, $path);
   unset($album_paths[$index]);
   $album_paths = array_values($album_paths);
   $num_albums--;
   insert_track_chance(80);
   insert_track_chance(5);
}

file_get_contents("http://192.168.1.11:9000/anyurl?p0=play&player=$player_id");


function insert_track_chance($percent){

    $random = mt_rand(0,100);
    if ($random < $percent){
      insert_track();
    }

}

function insert_track(){
   global $track_paths, $server, $player_id;
   
   if(sizeof($track_paths) == 0) {return;}
   $index =  mt_rand(0,sizeof($track_paths)-1);
   $path = $track_paths[$index];
   print "Adding track $path <br / >";
   squeezebox_enqueue($server,$player_id, $path);
   unset($track_paths[$index]);
   $track_paths = array_values($track_paths);
}


?>
