<?
$sortBy=$_POST['sortBy'];
$mysqli = new mysqli("blog.ru", "root", "", "blog");
if ($mysqli->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$res = $mysqli->query("SELECT id,date,title,avg(rate) as rate FROM articles left join Rates on Id=ArticleId group by id ORDER BY ".$sortBy." DESC");
while($rows[] = mysqli_fetch_assoc($res));
array_pop($rows);
echo json_encode($rows);