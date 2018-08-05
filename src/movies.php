<?php
if(file_exists()) {
    $fp = file_get_contents("/var/www/html/radarr.json");
    $json = json_decode($fp);
}
else {
    echo "Error grabbing JSON file, if this is the first boot of the container it may take a minuite to grab the data!";
    exit();
}

function mySort($a, $b) {
  return strnatcmp($a->title, $b->title);
}
//natsort($json);
//$json = json_decode(json_encode($json));
$moviecount = 0;
foreach($json as $key=>$val)
{
	$moviecount++;
}
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style type="text/css">
        .progress.episode-progress {
            position: relative;
            width: 250px;
        }

        .progressbar-back-text, .progressbar-front-text {
            width: 250px;
        }

        .progressbar-back-text, .progressbar-front-text {
            font-size: 12px;
            font-weight: bold;
            text-align: center;
            cursor: default;
            line-height: 40px;
        }

        .progressbar-back-text {
            position: absolute;
            height: 100%;
        }

        .progressbar-front-text {
            display: block;
            height: 100%;
        }

        .progress-bar {
            position: absolute;
            overflow: hidden;
			height: 40px !important;
        }
		.progress {
			height: 40px !important;
		}
		.rowheader {
			background-colour: #030303;
			border-bottom: 3px solid #000000;
			font-weight: bold;
		}
		.show-title {
			font-weight: bold;
		}
		/*.row :nth-child(even){
			background-color: #dcdcdc;
		}
		.row :nth-child(odd){
			background-color: #aaaaaa;
		}*/
		.rowborder {
			padding-bottom: 5px;
			padding-top: 5px;
			border-bottom: 1px solid #000000;
		}
		.text {
			line-height: 40px;
		}
    </style>
    <title>Radarr tracker</title>
</head>
<body>
<div class="container-fluid">
    <h1>Movie Tracker - <?php echo $moviecount; ?> Movies</h1>
	<div class="row rowheader">
		<div class="col-lg-6">Movie Title</div>
		<div class="col-lg-6">Quality</div>
	</div>
	<?php
			foreach($json as $show=>$vals)
			{
				$colour = "";
				if($vals->got == true){
					$colour = "bg-success";
					$quality = $vals->quality;
				} else {
					if($vals->grabbed == true)
					{
						$colour = "bg-warning";
						$quality = "In Download Queue";
					}
					else {
						$colour = "bg-danger";
						$quality = "Not Found Download/Not Available Yet";
					}
				}
				echo "<div class=\"row rowborder\">".PHP_EOL;
				echo "	<div class=\"col-lg-6 show-title text\">". $vals->title . "</div>".PHP_EOL;
				echo "	<div class=\"col-lg-6\">".PHP_EOL;
				echo "		<div class=\"progress episode-progress ".$colour."\">".PHP_EOL;
				echo "			<span class=\"progressbar-back-text\">".$quality."</span>".PHP_EOL;
				echo "		</div>".PHP_EOL;
				echo "	</div>".PHP_EOL;
				echo "</div>".PHP_EOL;
			}//
			?>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>