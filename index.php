<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>RecordsOnline</title>

	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="/DataTables/datatables.css">
</head>
<body>
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" charset="utf8" src="/DataTables/datatables.js"></script>


<script>
$(document).ready(function() {

	        
	var table = $('#mytable').DataTable( {

    aoColumnDefs: [{orderable: false, aTargets : [2]}], 
    "order": [0, 'desc'], 
    "paging":   false,        
    "info":     false,
    "sDom": '<"top"i>rt<"bottom"lp><"clear">'
    } );


		$('#myInput').on( 'keyup', function () {

			document.getElementById("enter").onsubmit=
		 	function() {
		  		window.location.href = "index.php?search=" + this.mytext.value;
		  		return false;
		 	}

			$('#myInput').on( 'keyup', function () {
				table
			.search(this.value)
			.draw();
			});
		} );
} );


</script>

<?php

session_start();

    if (isset($_SESSION['pl']) AND $_SESSION['del'] == true)	
	{
		unlink($_SESSION['pl']);
	}
date_default_timezone_set('Europe/Minsk');


	echo '<table id="mytable" class="table table-hover table-bordered table-row text-center">
		<thead>
                     <tr>
                     <th>Дата звонка</th>
                     <th>Телефон абонента</th>
                     <th>Play</th>
                     </tr>
                     </thead>';

    if(isset($_GET['search']))
    {
    	Files('*.WAV');
		Files('*/*.WAV');
		Files('*/*/*.WAV');
		Files('*/*/*/*.WAV');	
    }

	echo "</table>"; 

	$play = Player();

function Player()
{
	if(isset($_GET['play']))
	{

		$fpath = $_GET['play'];
		$path = substr($fpath, 0, -4);

		$pathes = "$fpath $path[0]";

		exec('E:\Programs\XAMPP\htdocs\ffmpeg-20170918-18821e3-win64-static\bin\ffmpeg.exe -i '.$pathes.'new.wav');

		return $path[0].'new.wav';

	}
}

function Files($dir)
{
	foreach (glob($dir) as $filename) 
	{
		$path = $filename;
		$filename = end(explode('/', $filename));

		if(stristr($filename, $_GET['search']) == true)
		{

			echo "<tr>";
	    	$datetime = ConvDate($filename);
	        echo "<td>$datetime</td>"; 

			$number = strtok(".");

			if (strlen($number) == 12)
			{
				$number1 = substr($number, -7);
				$code = substr($number, -9, 2);
				$number = "+375(".$code.")".$number1;
			}
	   		echo "<td>$number</td>"; 
	        		
	    	echo "<td><a href='index.php?play=".$path."'><span class='glyphicon glyphicon-play'></span></a></td>
	    	</tr>";
		}
	} 
}

function ConvDate($name)
{
	$date = strtok($name, "-"); 
	$time = strtok("-");
	$datetime1 = "$date $time";
	$datetime = date_create($datetime1);
	$datetime = date_format($datetime, 'Y-m-d H:i:s');

	return $datetime;
}
?>

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">RecordsOnline</a>
    </div>

    <ul class="nav navbar-nav">
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Отобразить
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="#">Брест</a></li>
          <li><a href="#">Пинск</a></li>
          <li><a href="#">Кобрин</a></li>
        </ul>
      </li>
    </ul>

    <form name="form1" class="navbar-form navbar-left" id="enter" method="POST">
      <div class="form-group">
        <input id="myInput" name="mytext" type="text" class="form-control" placeholder="Поиск">
        
      </div>
    </form>

    <div class="navbar-form navbar-right">
    	<audio controls autoplay>

						 	  	  <source src="<?php echo $play ?>" type="audio/wav">
						 	  		Если вы видите это, значит ваш браузер не
						 	  		поддерживает теги HTML5 аудио.
		</audio>    		
    </div>
</div>
</nav> 

</body>
</html>

<?php
	$_SESSION['del'] = true;
	$_SESSION['pl'] = $play;
?>