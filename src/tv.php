<?php
if(file_exists("/var/www/html/sonarr.json"))
{
    $fp = file_get_contents("/var/www/html/sonarr.json");
    $json = json_decode($fp); 
}
else {
    echo "Error grabbing JSON file, if this is the first boot of the container it may take a minuite to grab the data!";
    exit();
}
$showcount = 0;
foreach($json as $key=>$val)
{
	$showcount++;
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
    <title>Sonarr tracker</title>
</head>
<body>
<div class="container-fluid">
    <h1>TV Tracker - <?php echo $showcount; ?> Shows</h1>
	<div class="row rowheader">
		<div class="col-lg-6">Show Title</div>
		<div class="col-lg-3">Downloaded / Total</div>
		<div class="col-lg-3">Percent</div>
	</div>
	<?php
			foreach($json as $show=>$vals)
			{
                $colour = "";
                if($vals->total >= 1)
                {
                    $percent = ($vals->got / $vals->total) * 100;
                }
                else {
                    $percent = 0;
                }
				
				$percent = number_format($percent, 2, ".", ",");
				if($percent == 100)	{
					$colour = "bg-success";
				} elseif(($percent < 100) && ($percent > 50)) {
					$colour = "bg-warning";
				} elseif($percent <= 50) {
					$colour = "bg-danger";
				}
				echo "<div class=\"row rowborder\">".PHP_EOL;
				echo "	<div class=\"col-lg-6 show-title text\">". $vals->title . "</div>".PHP_EOL;
				echo "	<div class=\"col-lg-3\">".PHP_EOL;
				echo "		<div class=\"progress episode-progress\">".PHP_EOL;
				echo "			<span class=\"progressbar-back-text\">".$vals->got." / ".$vals->total."</span>".PHP_EOL;
				echo "				<div class=\"progress-bar ".$colour."\" role=\"progressbar\" style=\"width:".$percent."%\" aria-valuenow=\"".$percent."\" aria-valuemin=\"0\" aria-valuemax=\"100\">".PHP_EOL;
				echo "					<span class=\"progressbar-front-text\">".$vals->got." / ".$vals->total."</span>".PHP_EOL;
				echo "				</div>".PHP_EOL;
				echo "		</div>".PHP_EOL;
				echo "	</div>".PHP_EOL;
				echo "	<div class=\"col-lg-3 text\">".$percent."%</div>".PHP_EOL;
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