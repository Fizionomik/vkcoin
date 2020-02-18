<?php

header('Access-Control-Allow-Origin: *');

$mysql_host = "localhost";
$mysql_database = "m991451y_vccoin";
$mysql_user= "m991451y_vccoin";
$mysql_password = "vkcoin";

$link = mysql_connect($mysql_host,$mysql_user, $mysql_password) or die("error connect");
mysql_select_db($mysql_database,$link) or die("error db");



if(isset($_POST["name"])) $name = $_POST["name"];
if(isset($_POST["score"])) $score = $_POST["score"];
if(isset($_POST['client']))$client=$_POST['client'];
if(isset($_POST['sum']))$sum=$_POST['sum'];

if(isset($name)&&isset($score)){
    //Запрос к БД на получение нужной строки
    $q1 = mysql_query("SELECT * FROM result_table WHERE name='".$name."'");
    if(mysql_num_rows($q1)==1){
        $array = mysql_fetch_array($q1);
        if($score!=$array['score']) $q2 = mysql_query("UPDATE result_table SET `score`='$score' WHERE `name`='$name'");
    }else{
        $q3 = mysql_query("INSERT INTO result_table (`name`,`score`) VALUES ('".$name."','".$score."') ");
    }
}

$q4 = mysql_query("SELECT * FROM result_table ORDER BY score DESC");
while($row=mysql_fetch_row($q4)){
    if($i<10){
        echo $row[0].' - '.$row[1].' | ';
        $i=$i+1;
    }
}
if(isset($name)&&isset($client)&&isset($sum)){
    //выбираем владельца и клиента
 $n1=mysql_query("SELECT * FROM `result_table` WHERE `name`='$name'");
 $c1=mysql_query("SELECT * FROM `result_table` WHERE `name`='$client'");
 
 if(mysql_num_rows($n1)==1&&mysql_num_rows($c1)==1){
	$array1=mysql_fetch_array($n1);
	$array2=mysql_fetch_array($c1);
	//вычисляем счет владельца акка
	$endscore=$array1['score']-$sum;
	$endclient=$array2['score']+$sum;
	//перезаписываем строки в бд у владельца и клиента
	$n2=mysql_query("UPDATE result_table SET score='$endscore' WHERE name='$name'");
	$c2=mysql_query("UPDATE result_table SET score='$endclient' WHERE name='$client'");
}

}
?>