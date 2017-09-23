<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href="css/style.css" media="screen" rel="stylesheet">
</head>
<body>

<?php

date_default_timezone_set('Europe/Minsk');

echo '<table align= "center" style="border-collapse: collapse; text-align:center;" bgcolor="#ffffff" border="1px">
					 <col width="30">	
                     <col width="300">
                     <col width="170">
                     <col width="170">

                     <tr><th></th>
                     <th>Название записи</th>
                     <th>Дата звонка</th>
                     <th>Телефон абонента</th>
                     </tr>';

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

				echo "<div id='parent_popup'>
	            <div id='popup'>
	                <form action = 'index.php?delete=".$path[0]."' method = 'post'>
	                <p> <input class='button' type='submit' name='close' value='Закрыть'></p>
	                <p> <audio controls autoplay>
						 <source src='".$path[0]."new.wav' type='audio/wav'>
						 Если вы видите это, значит ваш браузер не
						 поддерживает теги HTML5 аудио.
						</audio>
					</p>
	                </form>
	            </div>
	          </div>";
	}
}

function Files($dir)
{
	foreach (glob($dir) as $filename) 
	{
	$path = $filename;
	$filename = end(explode('/', $filename));

	echo "<tr><td><a href='index.php?play=".$path."' style='text-decoration: none;'><font size='5' color='#16711C'>&#9658;</font></a></td>";
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
