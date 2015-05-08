<?php
$server = "192.168.1.11";
$store_album_buffer = "./list/store_album.list";

$scenes["wakeup"]["music_list"] = "./list/wakeup.list";
$scenes["wakeup"]["volume_level"] = "30";
$scenes["wakeup"]["run_if_playing"] = true;

$scenes["wakeup_again"]["music_list"] = "./list/wakeup.list";
$scenes["wakeup_again"]["volume_level"] = "50";
$scenes["wakeup_again"]["run_if_playing"] = false;

$scenes["sexytime"]["music_list"] = "./list/sexytime.list";
$scenes["sexytime"]["volume_level"] = "50";
$scenes["sexytime"]["run_if_playing"] = true;

$scenes["sleepytime"]["music_list"] = "./list/sleepytime.list";
$scenes["sleepytime"]["volume_level"] = "20";
$scenes["sleepytime"]["run_if_playing"] = true;

$scenes["ampersand"]["music_list"] = "./list/ampersand.list";
$scenes["ampersand"]["track_list"] = "./list/ampersand-tracks.list";
$scenes["ampersand"]["volume_level"] = "50";
$scenes["ampersand"]["run_if_playing"] = true;

$scenes["jason"]["music_list"] = "./list/jason.list";
$scenes["jason"]["volume_level"] = "50";
$scenes["jason"]["run_if_playing"] = true;

$scenes["maura"]["music_list"] = "./list/maura.list";
$scenes["maura"]["volume_level"] = "50";
$scenes["maura"]["run_if_playing"] = true;

$player_ids["bedroom"]= "00%3A04%3A20%3A26%3Af7%3A20";
$player_ids["kitchen"]= "00%3A04%3A20%3A29%3Ac2%3A46";
$player_ids["bathroom"]="00%3A04%3A20%3A27%3A1a%3A8f";
?>
