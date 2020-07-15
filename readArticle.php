<?
header("Content-type: text/html; charset=utf-8");
?>
<!DOCTYPE html>
<html>
 <head>
 <meta http-equiv="content-type" content="text/html; charset=utf-8" />
 <title></title>
 <link rel="stylesheet" type="text/css" href="blog.css">
 </head>
 <body>
 <?
require('header.php');
$mysqli = new mysqli("blog.ru", "root", "", "blog");
if ($mysqli->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$res = $mysqli->query("SELECT id,date,title,text,avg(rate) as rate FROM articles left join Rates on Id=ArticleId group by id having id=".$_GET["article"]);
while ($row = mysqli_fetch_array($res)) {
    echo "<h1>".$row["title"]."</h1>";
	echo "<div>".$row["date"]."</div>";
	echo "<div>".$row["text"]."</div>";
	echo "<div class='articleRate'> Оценка ".$row["rate"]."</div>";
	echo "<form action='changeRate.php' method='post'>
	<input type='hidden' value='".$row["id"]."' name='id'>
	<input type='range' min='1' max='5' id='rateRange' name='newRate'/>
	<input type='submit' value='Оценить'/>
	</form>";
}
echo "<form action='index.php'><input type='submit' value='К списку статей'/></form>";
 ?>
 </body>
 </html>