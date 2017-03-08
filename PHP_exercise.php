<?php

$x=5;
$y=10;
function myTest($z = 20) {
  global $x,$y; // 局部作用域
  echo "测试函数内部的变量：";
  echo "变量 x 是：$x";
  echo "<br>";
  echo "变量 y 是：$y";
  echo "变量 z 是:", $z;
  echo '<br>';
} 

myTest(1111);

echo "测试函数之外的变量：", "变量 x 是：$x";
echo "<br>";
echo "变量 y 是：$y";

$a="asdfg";
var_dump('sfef');
var_dump(1.2E1);
$a=false;
var_dump($a);

echo '<br>',strlen('123456'),'<br>';
echo var_dump(strpos('hello world', 'a'));
define("GREETING", "Welcome to W3School.com.cn!", true);
echo greeting, "<br>";
$color = array('green', 'red', 'blue');
foreach($color as $value) {
	echo $value, "<br>";
}
$car = array('1'=>'qq', '4'=>'bmw'); //一部小心就定义了一个二维数组
echo $car;   //输出的是Array，真奇怪
$car1 = array('3'=>'volvo');

echo '<br>';
$car += $car1;
echo var_dump($car);
echo '<br>';
for(; ;) {
	echo $x++;
	if($x == 10)
		break;
}
echo '<br>';
$number = array(5, 7, 3, 4);
foreach($number as $num) {
	echo $num;
}

//关联数组遍历
echo '<br>';
foreach($car as $x) {
	echo $x, '<br>';
}

//数组排序
sort($car);
var_dump($car);

//$GLOBAL超全局
function add() {
	$z = $GLOBALS['y'] + $GLOBALS['y'];
	echo '两个超全局变量的和：', $z, '<br>';
}
add();

function input_test($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
$nom = $prenom = $comment = '';
$nom = input_test($_REQUEST['Nom']);
$prenom = input_test($_REQUEST['Prenom']);
$comment = input_test($_REQUEST['Commentaires']);
echo $nom, '	', $prenom, '	', $comment, '<br>';
echo '_$_REQUEST超全局变量收集信息：', $_REQUEST['Nom'], '<br>';
echo '$_$_GET超全局收集信息：', $_GET['Sexe'], '<br>';
echo '$_$_POST超全局收集信息：', $_POST['Fonction'], '<br>';

//多维数组

}

?>


























