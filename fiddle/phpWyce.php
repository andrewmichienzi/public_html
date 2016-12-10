<?php
$xml = file_get_contents("https://grcmc.org/wyce/playlists/date/2016-12-06.json");
$file = "outputPhp.txt";
$string="";
$GLOBALS['findProgrammer']="Linda";
if($xml)
{
	$json = json_decode($xml, true);
	$playlists = null;
	foreach($json as $key=>$val) {
		if(strcmp($key,"data")==0)
		{
			foreach($val as $key2=>$val2)
			{
				if(strcmp($key2,"playlist")==0)
				{
					foreach($val2 as $list=>$val3)
					{
						parsePlaylistData($val3);
					}
				}
			}
		}
	}
}

function parsePlaylistData($json)
{
	$programmer = "";
	$date = "";
	$time = "";
	foreach($json as $key=>$val)
	{
		if(strcmp($key, "programmer")==0)
			$programmer = $val;
		if(strcmp($key, "date")==0)
			$date = $val;
		if(strcmp($key, "time")==0)
			$time = $val;
		if((strcmp($key, "sets")==0) && (strcmp($programmer, $GLOBALS['findProgrammer'])==0))
			parseSets($programmer, $date, $time, $val);
	}	
}

function parseSets($programmer, $date, $time, $sets)
{
	foreach($sets as $setNum=>$val)
	{
		if(is_array($val))
		{
			//tracks
			$arr = $val;
			$tracks = $arr['tracks'];
			foreach($tracks as $key=>$value)
			{
				foreach($value as $k=>$v)
				{
					echo "$k: $v\n";
				}
			echo "\n\n";
			}
		}
	}
}

class playlist
{
	var $programmer;
	var $date;
}

?>
