<?
$mysqli = new mysqli("blog.ru", "root", "", "blog");
if ($mysqli->connect_errno) {
    echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

//header('Location: readArticle.php?article=');