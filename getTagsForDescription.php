<?php

/*
========================  NOTE  ==========================

THIS FILE IS USED TO GET THE RELEVANT TAGS FOR THE DESCRIPTIO OF A PROJECT.
*/

$start_time = microtime(TRUE);


$connect=mysqli_connect("localhost","sundar","connect2database","dictionary");
if (mysqli_connect_errno()) 
{
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// adding a 'space' to confirm an array when exploded
$words = $_POST['description']." ";

$delimiters = array(" ", "\n", ",", ".");
$keywords = explode($delimiters[0],strtr($words,array_combine(array_slice($delimiters,1),array_fill(0,count($delimiters)-1,array_shift($delimiters)))));

// To avoid redundant words
$lim = count($keywords);
sort($keywords);
$j = 0;

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

// Getting tag for each key available
foreach ($keyset as $key) 
{
    $qry = "SELECT `tag` FROM `keys` WHERE `keyword` = '$key' ";
	$result= mysqli_query($connect,$qry);
	if($result)
	{
		while($row = mysqli_fetch_array($result))
		{
			$tags[] = $row['tag'];
		}
	}
	else
	{
		$query = "INSERT INTO `no_tags` (`word`) VALUES ('$key')";
		mysqli_query($query);
	}
	
}

sort($tags);

for($i = 0; $i < count($tags) - 1 ; $i++)
{
    if(strcmp($tags[$i],$tags[$i+1]) == 0)
        continue;
    else
    {
        $tagset[] = $tags[$i];
    }
}
$tagset[] = $tags[$i];

//  echo json_encode($tagset);

/*        							Note
===========          $tagset has the tags for the description             =============
*/
mysqli_close($connect);

$end_time = microtime(TRUE);

echo $end_time - $start_time;
?>		