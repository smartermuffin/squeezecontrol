<?php

require("./config.php");

if(isset($_GET["player"])){
    $player = $_GET["player"];
    $player_id = $player_ids[$player]; 
    store_albums($player_id,$store_album_buffer);
    exit;
}

if(isset($_GET["merge_into_scene"])){
   $scene = $_GET["merge_into_scene"];
   $scene_list_file = $scenes[$scene]["music_list"];
   merge_into_scene($scene_list_file, $store_album_buffer);   
   exit;
}



function store_albums($player_id, $buffer_file_name){
  $playlist = file_get_contents("http://192.168.1.11:9000/status.m3u?player=$player_id");
  $files = array();
  $dirs = array();

  foreach(preg_split("/((\r?\n)|(\r\n?))/", $playlist) as $line){
    if (!strpos($line, "EXTURL") and $line != ""){
      array_push($files, $line);
    }
  } 

  foreach ($files as $file){
     $slashpos = strrpos($file, "/");
     $dir = substr($file,0,$slashpos +1);
     $dirs[$dir]++;
  }


  $file = fopen($buffer_file_name,"w") or die("could not open file");



  foreach (array_keys($dirs) as $d){
    print "$d <br />";
    fwrite($file, "$d\n");
  }  

  fclose($file);
}




function merge_into_scene($scene_list_file, $store_album_buffer){
   print "$store_album_buffer -> $scene_list_file";
   $dirs = array();

   $scene_list = fopen($scene_list_file,"r") or die("could not open scene list for read");

   while(!feof($scene_list)) {
   $dir = fgets($scene_list);
   if ($dir != ""){
    $dirs[$dir]++;
   }
  } 
  
  fclose($scene_list);



  $buffer_list = fopen($store_album_buffer,"r") or die("could not open buffer list for read");

   while(!feof($buffer_list)) {
   $dir = fgets($buffer_list);
   if ($dir != ""){
    $dirs[$dir]++;
   }
  }

  fclose($buffer_list);

  print "<br / > <br / > ";
  print_r($dirs);

 print "<br / > <br / > ";
 $new_list = fopen($scene_list_file,"w") or die("could not open scene list for write");

 foreach (array_keys($dirs) as $d){
    if ($d == "\n") continue;
    print "$d <br />";
    fwrite($new_list, "$d");
  }

 fclose($new_list);


} 

?>
