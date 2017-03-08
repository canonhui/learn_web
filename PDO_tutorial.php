<?php

try {
	$dns = 'mysql:host=localhost;dbname=test';
	$options = array (
		PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
	);
	$db = new PDO($dns, 'root', '');
	echo '连接成功<br>';
} catch(Exception $e) {
	echo '连接失败<br>', $e -> getMessage();
	die();
}
//PDO::exec()方法返回一个影响记录的结果：
//$count = $db -> exec("DELETE FROM test where 07:13:08");
//echo $count, '<br>';
//$count = $db -> exec("INSERT INTO test SET name = 'éééééé', gender = '女的', time = NOW()");
//echo $count;

//提取数据
foreach($db -> query('SELECT * FROM test') as $row) {
//	print_r($row); //print_r()函数可以打印打印一个数组
}

$rs = $db -> query('SELECT * FROM test');
$rs -> setFetchMode(PDO::FETCH_OBJ);  //必须有这个声明后面才能用
/*
while($row = $rs -> fetch()) {
	echo '<h1>', $row -> name, ' ', $row -> gender, ' ', $row -> time, '</h1>';
}*/

/*这种fetch和上面
while($row = $rs -> fetch(PDO::FETCH_OBJ)) {
	echo '<h1>', $row -> name, ' ', $row -> gender, ' ', $row -> time, '</h1>';
}
*/

$creatures = $rs -> fetchAll(PDO::FETCH_OBJ); //如名，fetch所有行
print_r(next($creatures));
while($row = next($creatures)) {
	echo '<h1>', $row -> name, ' ', $row -> gender, ' ', $row -> time, '</h1>';
}
/*
$rsPrepa = $db -> prepare('SELECT * FROM test where time = ? LIMIT 1');
try {
	$rsPrepa -> execute(array('06:44:18'));
	if($row = $rsPrepa -> fetch(PDO::FETCH_OBJ)) {
		echo '<h1>', $row -> name, ' ', $row -> gender, ' ', $row -> time, '</h1>';
	}
} catch(Exception $e) {
	echo 'Erreur de supression: ', $e -> getMessage();
}
*/
$rsPrepa = $db -> prepare('SELECT * FROM test where name LIKE: search');
$rsPrepa -> execute(array('search' => '*xiao'));
while($row = $rsPrepa -> fetch(PDO::FETCH_OBJ)) {
	echo '<h1>', $row -> name, ' ', $row -> gender, ' ', $row -> time, '+22</h1>';
}

/*
$insert = $db -> prepare('INSERT INTO test VALUES(
	:name, :gender, :time)');
$success = $insert -> execute(array(
	'name' => 'bighui',
	'gender' => 'boy',
	'time' => '07:57:12'));
if($success)
	echo 'suceess', $success;
else
	echo 'echoue';
*/
$name = 'xiaohuihui';
$gender = 'man';
$time = '08:08:08';
$insert = $db -> prepare('DELETE FROM test where :name, :gender) limit 1');
$insert -> bindParam(':name', $name, PDO::PARAM_STR);
$insert -> bindParam(':gender', $gender, PDO::PARAM_STR);
//$insert -> bindParam(':time', time('h:m:s');
$success = $insert -> execute();
if($success)
	echo 'success', $success;
else 
	echo 'echoue';
//$success = $db -> exec("DELETE FROM test where name = 'od' LIMIT 1");
//echo $success;
?>