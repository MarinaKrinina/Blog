<?
header("Content-type: text/html; charset=utf-8");
require('header.php');
echo "<form action='login.php' method='post'>
Логин <input type='text' name='login'/>
Пароль <input type='password' name='password'/>
<input type='submit' value='Войти' />
</form>";
$login=$_POST['login'];
$password=$_POST['password'];
if ($login!='' && $password!='') {
	$mysqli = new mysqli("blog.ru", "root", "", "blog");
	if ($mysqli->connect_errno) {
		echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	$res = $mysqli->query("SELECT * FROM users WHERE login=".$login." AND password=".$password.";");
	if ($row = mysqli_fetch_array($res)) {
		$_SESSION["user"]=$row['id'];
		echo "Вы успешно зашли";
	} else {
		echo "Неверный логин или пароль";
	}
}