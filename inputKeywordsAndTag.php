<?php

/*
==============  NOTE  ==============
THIS IS FOR CHECKING AND GOD USE PURPOSE ONLY.
*/


$start_time = microtime(TRUE);

$connect=mysqli_connect("localhost","sundar","connect2database","dictionary");
    if (mysqli_connect_errno()) 
    {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

session_start(); 
$tag=$_POST['tag'];
$keywords = strtolower($_POST['keywords']);

$delimiters = array(" ", "\n", ",", ".");
$keywords = explode($delimiters[0],strtr($keywords,array_combine(array_slice($delimiters,1),array_fill(0,count($delimiters)-1,array_shift($delimiters)))));

$lim = count($keywords);
sort($keywords);
$j = 0;
var_dump($keywords);
for($i = 1; $i < $lim ; $i++)
{
    if(strcmp($keywords[$i-1],$keywords[$i]) == 0)
        continue;
    else
    {
        $keyset[$j] = $keywords[$i];
        $j++;
    }
} 

foreach ($keyset as $key) {
    $res="INSERT INTO  `keys` (`tag` ,`keyword`) VALUES ( '$tag',  '$key');";        
    $a=mysqli_query($connect,$res);
}

var_dump($keyset);

echo json_encode($keyset);

mysqli_close($connect);

$end_time = microtime(TRUE);
// for benchmarking
echo $end_time - $start_time;

?>	
