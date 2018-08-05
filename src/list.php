<?php
include("./config/config.php");
//sonarr
$api = file_get_contents("https://sonarr.".$domain."/api/series?apikey=".$sonarrAPI);
$json = json_decode($api);
foreach($json as $show=>$val) {
	$array[$val->titleSlug]["title"] = $val->title;
	$array[$val->titleSlug]["got"] = $val->episodeFileCount;
	$array[$val->titleSlug]["total"] = $val->episodeCount;
}
$fp = fopen("/var/www/html/sonarr.json", "w+");
fwrite($fp, json_encode($array));
fclose($fp);

unset($array);
//radarr
$api = file_get_contents("https://radarr.".$domain."/api/movie?apikey=".$radarrAPI);
$json = json_decode($api);
$api = file_get_contents("https://radarr.".$domain."/api/history?page=1&pageSize=4000&sortKey=movie.title&apikey=".$radarrAPI);
$history = json_decode($api);
foreach($json as $show=>$val) {
	$title = str_replace(" ", "_", $val->sortTitle);
	$array[$val->titleSlug]["title"] = $val->title;
	$array[$val->titleSlug]["got"] = $val->hasFile;
	if($val->hasFile)
	{
		$array[$val->titleSlug]["quality"] = $val->movieFile->quality->quality->name;
	}
	else {
		foreach($history->records as $key=>$record)
		{
			$array[$val->titleSlug]["grabbed"] = false;
			if($record->movieId == $val->id)
			{
				//print_r($record);
				echo $record->eventType.PHP_EOL;
				if($record->eventType == "grabbed")
				{
					$array[$val->titleSlug]["grabbed"] = true;
					break;
				}
			}
		}
	}
}
$fp = fopen("/var/www/html/radarr.json", "w+");
fwrite($fp, json_encode($array));
fclose($fp);