<?php
class Playlist
{
	public $programmer="";
	public $date="";
	public $time="";
	public $tracklist="";
	public $playlistName="";
	
	function printTracks()
	{
		foreach ($tracklist as $key=>$track)
		{
			foreach($track as $attrName=>$attr)
			{
				echo "$attrName: $attr\n";
			}
		}
	}
}
$xml = file_get_contents("https://grcmc.org/wyce/playlists/date/2016-12-06.json");
$file = "outputPhp.txt";
$string="";
$GLOBALS['findProgrammer']="Linda";
if($xml)
{
	$json = json_decode($xml, true);
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
	$playlist = new Playlist;
	$playlist->$programmer = $programmer;
	$playlist->$date = $date;
	$playlist->$time = $time;
	foreach($sets as $setNum=>$val)
	{
		if(is_array($val))
		{
			//sets
			$arr = $val;
			$tracks = $arr['tracks'];
			$i = 0;
			$playlist->$tracklist = $arr['tracks'];
			foreach($tracks as $key=>$track)
			{
				//track
				foreach($value as $k=>$v)
				{
					//Each attribute
					#echo "$k: $v\n";
				}
			#echo "\n\n";
			$i+=1;
			}
			#echo "i = $i";
		}
	$playlist->{printTracks()};
	}
}




?>
