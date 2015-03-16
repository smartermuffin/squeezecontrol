<?php

function squeezebox_is_playing($server, $player_id){
    $status_page = file_get_contents("http://$server:9000/status.html?player=$player_id");
    if(strpos($status_page, "Now Playing")) 
           {return true;}
    else
	   {return false;}
}


function squeezebox_enqueue($server, $player_id, $path){
   $url="http://$server:9000/anyurl?p0=playlist&p1=add&p2=".urlencode($path)."&player=".$player_id;
   file_get_contents($url);
}



function squeezebox_stop($server, $player_id) {
   $url="http://$server:9000/anyurl?p0=stop&player=".$player_id;
   file_get_contents($url);


}


?>
