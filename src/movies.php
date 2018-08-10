<?php
if(file_exists("/var/www/html/radarr.json")) {
    $fp = file_get_contents("/var/www/html/radarr.json");
    $json = json_decode($fp);
    if($json == null){
        echo "Error with JSON files check you have the correct URL and Radarr API key in /opt/appdata/pgtracker/config.php";
        exit();
    }
}
else {
    echo "Error grabbing JSON file, if this is the first boot of the container it may take a minuite to grab the data!";
    exit();
}
$moviecount = 0;
foreach($json as $key=>$val)
{
	$moviecount++;
}
?>
<html>
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
  <script src="movies.js"></script>
  <style type="text/css">
        .progress.episode-progress {
            position: relative;
            width: 100%;
        }

        .progressbar-back-text, .progressbar-front-text {
            width: 100%;
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
</head>

<body>

<div class="container jumbotron">
  <h1 style="text-align:center;">Movies - <?php echo $moviecount; ?> Movies</h1>
<div class="row">
  <form action="#" method="get" style="width:100%">
    <div class="input-group">
      <input class="form-control" id="system-search" name="q" placeholder="Search for Movies" aria-describedby="basic-addon2">
      <div class="input-group-append">
        <button class="btn btn-primary" type="button" id="button-addon2"><i class="fas fa-search"></i></button>
      </div>
    </div>
  </form>
</div><!-- end row -->

<div class="row">
  <table class="table table-list-search table-striped table-hover table-dark" style="text-align:center;" id="content">
    <thead>
        <tr>
            <th>Movie Title</th>
            <th>Downloaded / Quality</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>
</div>
</body>
</html>