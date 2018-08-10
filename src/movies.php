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
<html>
<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
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
  <table class="table table-list-search table-striped table-hover table-dark" style="text-align:center;">
    <thead>
        <tr>
            <th>Movie Title</th>
            <th>Downloaded / Quality</th>
        </tr>
    </thead>
    <tbody>
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
                /*
				echo "<div class=\"row rowborder\">".PHP_EOL;
				echo "	<div class=\"col-lg-6 show-title text\">". $vals->title . "</div>".PHP_EOL;
				echo "	<div class=\"col-lg-6\">".PHP_EOL;
				echo "		<div class=\"progress episode-progress ".$colour."\">".PHP_EOL;
				echo "			<span class=\"progressbar-back-text\">".$quality."</span>".PHP_EOL;
				echo "		</div>".PHP_EOL;
				echo "	</div>".PHP_EOL;
                echo "</div>".PHP_EOL;*/
                //new
                echo "<tr>".PHP_EOL;
                echo "    <td>". $vals->title . "</td>".PHP_EOL;
                echo "    <td>".PHP_EOL;
                echo "        <div class=\"progress episode-progress ".$colour."\"\">".PHP_EOL;
                echo "            <span class=\"progressbar-back-text\">".$quality."</span>".PHP_EOL;
                echo "        </div>".PHP_EOL;
                echo "    </td>".PHP_EOL;
                echo "</tr>".PHP_EOL;
            }
            ?>
    </tbody>
  </table>
</div>
</div>

  <script>
  $(document).ready(function() {
    var activeSystemClass = $('.list-group-item.active');

    //something is entered in search form
    $('#system-search').keyup( function() {
       var that = this;
        // affect all table rows on in systems table
        var tableBody = $('.table-list-search tbody');
        var tableRowsClass = $('.table-list-search tbody tr');
        $('.search-sf').remove();
        tableRowsClass.each( function(i, val) {

            //Lower text for case insensitive
            var rowText = $(val).text().toLowerCase();
            var inputText = $(that).val().toLowerCase();
            if(inputText != '')
            {
                $('.search-query-sf').remove();
                tableBody.prepend('<tr class="search-query-sf"><td colspan="6"><strong>Searching for: "'
                    + $(that).val()
                    + '"</strong></td></tr>');
            }
            else{
              $('.search-query-sf').remove();
            }

            if( rowText.indexOf( inputText ) == -1 )
            {
                //hide rows
                tableRowsClass.eq(i).hide();

            }
            else
            {
                $('.search-sf').remove();
                tableRowsClass.eq(i).show();
            }
        });
        //all tr elements are hidden
        if(tableRowsClass.children(':visible').length == 0)
        {
            tableBody.append('<tr class="search-sf"><td class="text-muted" colspan="6">No entries found.</td></tr>');
        }
    });
});
  </script>
</body>
</html>