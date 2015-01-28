<?php
$server = "192.168.1.11";
$store_album_buffer = "./store_album.list";

$scenes["wakeup"]["music_list"] = "./wakeup.list";
$scenes["wakeup"]["volume_level"] = "30";
$scenes["wakeup"]["run_if_playing"] = true;

$scenes["wakeup_again"]["music_list"] = "./wakeup.list";
$scenes["wakeup_again"]["volume_level"] = "50";
$scenes["wakeup_again"]["run_if_playing"] = false;

$scenes["sexytime"]["music_list"] = "./sexytime.list";
$scenes["sexytime"]["volume_level"] = "50";
$scenes["sexytime"]["run_if_playing"] = true;

$scenes["sleepytime"]["music_list"] = "./sleepytime.list";
$scenes["sleepytime"]["volume_level"] = "20";
$scenes["sleepytime"]["run_if_playing"] = false;

$player_ids["bedroom"]="00%3A04%3A20%3A26%3Af7%3A20";

?>
