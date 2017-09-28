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
	<script src="https://code.jquery.com/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript" charset="utf8" src="/DataTables/datatables.js"></script>


<script>
$(document).ready(function() {
    var table = $('#mytable').DataTable( {

        aoColumnDefs: [{orderable: false, aTargets : [0]}], 
        "order": [1, 'asc'], 
        "paging":   false,        
        "info":     false

    } );



	
	$('#myInput').on( 'keyup', function () {
	    table
	        .search( this.value )
	        .draw();
	} );




} );







</script>


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


    <form class="navbar-form navbar-left">
      <div class="form-group">
        <input id="myInput" type="text" class="form-control" placeholder="Поиск">
      </div>
    </form>

</nav> 


<?php

date_default_timezone_set('Europe/Minsk');

echo '<table id="mytable" class="table table-hover table-bordered table-row text-center ">
		<thead>
                     <tr>
                     <th>Play</th>
                     <th>Название записи</th>
                     <th>Дата звонка</th>
                     <th>Телефон абонента</th>
                     </tr>
                     </thead>';

Files('*.WAV');
Files('*/*.WAV');
Files('*/*/*.WAV');
Files('*/*/*/*.WAV');

echo "</table>"; 

Player();

	if (isset($_POST['close']) AND isset($_GET['delete']))
	{
		unlink($_GET['delete'].'new.wav');
		header("location:index.php");
	}




function Player()
{
	if(isset($_GET['play']))
	{
		$fpath = $_GET['play'];
		$path = explode(".", $_GET['play']);
		$pathes = "$fpath $path[0]";

		exec('E:\Programs\XAMPP\htdocs\ffmpeg-20170918-18821e3-win64-static\bin\ffmpeg.exe -i '.$pathes.'new.wav');

	  		echo '<div id="parent_popup">
	          		<div id="popup">
  					  <div class="panel panel-default">
    				    <div class="panel-heading">'."Воспроизводится: <b>",$fpath.'<b></div>
    					<div class="panel-body">
    					  <form action = "index.php?delete='.$path[0].'" method = "post">
	                		<p> <input  class="btn btn-default button" type="submit" name="close" value="Закрыть"></p>
	                		  <p> 
	                		  	<audio controls autoplay>
						 	  	  <source src="'.$path[0].'new.wav" type="audio/wav">
						 	  		Если вы видите это, значит ваш браузер не
						 	  		поддерживает теги HTML5 аудио.
								</audio>
							  </p>
	                	  </form>
    					</div>
  					  </div>
					</div>
				  </div>';
	}
}

function Files($dir)
{
	foreach (glob($dir) as $filename) 
	{
	$path = $filename;
	$filename = end(explode('/', $filename));

	echo "<tr>
			<td><a href='index.php?play=".$path."'><span class='glyphicon glyphicon-play'></span></a></td>";
    	echo "<td> $filename </td>"; 
    		$datetime = ConvDate($filename);
        	echo "<td>$datetime</td>"; 

				$number = strtok(".");
        		echo "<td>$number</td>"; 
        		
    echo "</tr>";
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




</body>
</html>
