<?php
   $stats=array();
   $size = 2000; 
   foreach (range(1,$size) as $i){
       $rand = mt_rand(1,100);
       #print "$i - $rand<br />";
       if(!isset($stats["$rand"])){
         $stats["$rand"] = 1;
         continue;
       }
       $stats["$rand"]++;

   }
 
   $keys = array_keys($stats);
   sort($keys, SORT_NUMERIC);
   foreach ($keys as $key){
     print "$key - $stats[$key] <br />";

   } 

?>
