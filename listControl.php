<style>
td{
   padding:5px 5px 5px 5px;
}
</style>

<?php

require("./config.php");

$add_scenes = array("sexytime","wakeup","ampersand","sleepytime","jason","maura");
$players = array("kitchen", "bedroom");

if(isset($_GET["showList"])) {
   $scene = $_GET["showList"];
   $scene_list_file = $scenes[$scene]["music_list"];
   show_list($scene, $scene_list_file);
   exit;

}
print "<table border=\"1\" style=\"font-size: 200%;\">";
foreach($add_scenes as $s) {
  $time = time();
  print "<tr><td>$s </td>";
  print "<td><a href=\"/squeezeControl/listControl.php?player=bedroom&merge_into_scene=$s&time=$time\">Merge</a></td>"; 
  print "<td> <a href=\"/squeezeControl/listControl.php?showList=$s\">Display</a></td>";
  print "<td><a href=\"/squeezeControl/listControl.php?playscene=$s&onplayer=bedroom\">Bedroom</a></td>";
  print "<td><a href=\"/squeezeControl/listControl.php?playscene=$s&onplayer=kitchen\">Kitchen</a></td>";
  print "</tr>";
}
print "</table>";

if (isset($_GET["playscene"]) && isset($_GET["onplayer"])) {
  $scene=$_GET["playscene"];
  $player=$_GET["onplayer"];
  $output=file_get_contents("http://127.0.0.1/squeezeControl/playmusic.php?scene=$scene&player=$player");
 
  header("Location: /squeezeControl/listControl.php"); 
  print "<br />";
  print $output;
  exit;
}


if(isset($_GET["player"]) && isset($_GET["merge_into_scene"]) && isset($_GET["time"]))
{
    if (time() -30 > $_GET["time"] ) {print "<br />Merge link expired"; exit;}

    $player = $_GET["player"];
    $player_id = $player_ids[$player];
    store_albums($player_id,$store_album_buffer);
    
    print "<br /> <br />";
    $scene = $_GET["merge_into_scene"];
    $scene_list_file = $scenes[$scene]["music_list"];
    merge_into_scene($scene_list_file, $store_album_buffer);

   exit;

}


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


function show_list($scene,$scene_list_file){
 $playlist = file_get_contents($scene_list_file); 
 $playlist = str_replace("\n", "<br />", $playlist);

 print "<a href=\"/squeezeControl/listControl.php\">back.. </a><br />";
 print "<h1>List $scene</h1> <br />";
 print $playlist;

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
     $dir = substr($dir,0,-1);
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
