<?php
  require("./squeeze_functions.php");   
  require("./config.php");

  $player_name = $_GET["player"];
  print "Player: $player_name <br / >";
  $player_id = $player_ids[$_GET["player"]];
  

  if (squeezebox_is_playing($server, $player_id)) {
    print "Squeezebox $player is currently playing <br / >";
  }
  else {
    print "Squeezebox $player is currently not playing <br />";
  } 
?>
