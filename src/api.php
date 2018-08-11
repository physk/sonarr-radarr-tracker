<?php
function array_search_partial($arr, $keyword) {
    $keywords = explode($keyword, " ");
    foreach($arr as $index => $string) {
        foreach($keywords as $key=>$val)
        {
            if (strpos(strtolower($string["title"]), $keyword) !== FALSE) {
                $tmp[] = $index;
            }
        }
    }
    return $tmp;
}
if(isset($_GET["q"])){ $query = html_entity_decode($_GET["q"]); } else { $query = ""; }
if(isset($_GET["type"])) {
    $type = $_GET["type"];
    switch($type) {
        case "movies":
            $file = file_get_contents("/var/www/html/radarr.json");
            $json = json_decode($file, true);
            if(!$query == ""){
                $matches = array_search_partial($json, strtolower($query));
                if($matches == null) { $array = array("return"=>"error", "error"=>"Null returned"); break; }
                if(is_array($matches)){
                    foreach($matches as $key=>$index)
                    {
                        $return[$index] = $json[$index];
                    }
                    $array = array(
                        "return" => true,
                        "items" => $return
                    );
                }
                
            }
            else {
                $array = array(
                    "return" => true,
                    "items" => $json
                );
            }
            break;
        case "tv":
            $file = file_get_contents("/var/www/html/sonarr.json");
            $json = json_decode($file, true);
            if(!$query == ""){
                $matches = array_search_partial($json, strtolower($query));
                if($matches == null) { $array = array("return"=>"error", "error"=>"Null returned"); break; }
                if(is_array($matches)){
                    foreach($matches as $key=>$index)
                    {
                        $return[$index] = $json[$index];
                    }
                    $array = array(
                        "return" => true,
                        "items" => $return
                    );
                }
                
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