<!DOCTYPE html>
<html lang="ru">
<head>
	<title></title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
</head>
<body>
	<script src="https://code.jquery.com/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

 <nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">RecordsOnline</a>
    </div>

    <ul class="nav navbar-nav">
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Сортировка
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="#">Дата (по возрастанию)</a></li>
          <li><a href="#">Дата (по убыванию)</a></li>
        </ul>
      </li>
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

    <form class="navbar-form">
		<div class="col-lg-6">
		    <div class="input-group">
		      <input type="text" class="form-control" placeholder="Search for...">
		      <span class="input-group-btn">
		        <button class="btn btn-default" type="button">Go!</button>
		      </span>
		    </div>
		  </div>
		</form>

</nav> 
<?php

date_default_timezone_set('Europe/Minsk');

echo '<table class="table table-hover table-bordered table-row">
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
    				    <div class="panel-heading">'."Воспроизводится: <b>",$path[0].'<b></div>
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
