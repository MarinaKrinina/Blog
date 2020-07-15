<?
header("Content-type: text/html; charset=utf-8");
require('header.php');
echo "<form action='registration.php' method='post' enctype='multipart/form-data'>
Логин <input type='text' name='login'/>
<input type='hidden' name='MAX_FILE_SIZE' value='524288000' />
Аватар <input type='file' accept='image/*'/ name='avatar'>
Пароль <input type='password' name='password1'/>
Повтор пароля <input type='password' name='password2'/>
<input type='submit' value='Зарегистрироваться' />
</form>";
$login=$_POST['login'];
$password1=$_POST['password1'];
$password2=$_POST['password2'];
$avatar = $_FILES['avatar'];
if ($password1!=$password2) {
	echo "Введенные пароли не совпадают";
} elseif ($password1=='' || $login=='') {
	echo "Логин и пароль - обязательные для заполнения поля";
	//добавить проверку на уникальный логин
} else {
	$mysqli = new mysqli("blog.ru", "root", "", "blog");
	if ($mysqli->connect_errno) {
		echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}

	$filePath  = $avatar['tmp_name'];
	$errorCode = $avatar['error'];
	if (($errorCode !== UPLOAD_ERR_OK || !is_uploaded_file($filePath)) && $errorCode !== UPLOAD_ERR_NO_FILE) {
		$errorMessages = array(
			UPLOAD_ERR_INI_SIZE   => 'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
			UPLOAD_ERR_FORM_SIZE  => 'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
			UPLOAD_ERR_PARTIAL    => 'Загружаемый файл был получен только частично.',
			UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
			UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
			UPLOAD_ERR_EXTENSION  => 'PHP-расширение остановило загрузку файла.',
		);
		$unknownMessage = 'При загрузке файла произошла неизвестная ошибка.';
		$outputMessage = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : $unknownMessage;
		die($outputMessage);
	}
	if ($errorCode == UPLOAD_ERR_OK) {
		//only one comment for my sweet man. sorry, I don't like to comment((
		//проверка является ли файл изображением. раскомментить в php.ini extension=fileinfo.so или extension=php_fileinfo.dll
		$fi = finfo_open(FILEINFO_MIME_TYPE);
		$mime = (string) finfo_file($fi, $filePath);
		if (strpos($mime, 'image') === false) die('Можно загружать только изображения.');
		
		$avatarName = time();
		$image = getimagesize($filePath);
		$extension = image_type_to_extension($image[2]);
		$format = str_replace('jpeg', 'jpg', $extension);
		if (!move_uploaded_file($filePath, __DIR__ . '/upload/' . $avatarName . $format)) {
			die('При записи изображения на диск произошла ошибка');
		}
	} else {
		$avatarName='null';
	}
	
	$res = $mysqli->query("INSERT INTO users(Login,Avatar,Password) VALUES (".$login.", ".$avatarName.", ".$password1.");");
	//echo json_encode($res);
	//сделать нормально, а не 1!!
	$_SESSION["user"]=1;
	echo "Вы успешно зарегистировались";
}