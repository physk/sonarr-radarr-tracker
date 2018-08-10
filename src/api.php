<?php
function array_search_partial($arr, $keyword) {
    foreach($arr as $index => $string) {
        if (strpos($string["title"], $keyword) !== FALSE)
            $tmp[] = $index;
    }
    return $tmp;
}
if(isset($_GET["q"])){ $query = $_GET["q"];} else { $query = ""; }
if(isset($_GET["type"])) {
    $type = $_GET["type"];
    switch($type) {
        case "movies":
            $file = file_get_contents("/var/www/html/radarr.json");
            $json = json_decode($file, true);
            if(!$query == ""){
                $matches = array_search_partial($json, $query);
                foreach($matches as $key=>$index)
                {
                    $return[$index] = $json[$index];
                }
                $array = array(
                    "return" => true,
                    "items" => $return
                );
            }
            else {
                $array = array(
                    "return" => true,
                    "items" => $json
                );
            }
        break;
    }
}
else {
    $array = array("return"=>"error", "error"=>"No type Specified");
}
echo json_encode($array);