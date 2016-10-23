<html>
<head>
    <title>Book-O-Rama Book Entry Results</title>
</head>
<body>
<h1>Book-O-Rama Book Entry Results</h1>
<?php
$isbn = $_POST['isbn'];
$author = $_POST['author'];
$title = $_POST['title'];
$price = $_POST['price'];
if(!$isbn || !$author || !$title  || !$price){
    echo "You have not entered all the required details.<br />"."please go back and try again.";
    exit;
}
if(!get_magic_quotes_gpc()){
    $isbn = addslashes($isbn);//某些字符前加上了反斜线。这些字符是单引号（'）、双引号（"）、反斜线（\）与 NUL（NULL 字符）。
    $author = addslashes($author);
    $title = addslashes($title);
    $price = doubleval($price);//=floatval()获取变量的浮点值$var = '122.34343The'打印出 122.34343
}
/*@$db = new mysqli('localhost','GuestL','cylinder','books');
if(mysqli_connect_errno()){
    echo "Error: Could not connect to database.please try again later.";
    exit;
}*/
/*$query = "insert into books values('".$isbn."', '".$author."', '".$title."', '".$price."')";
echo $query;
$result = $db->query($query);//入库时，MYSQL会自动吃掉反斜杠insert into books values('0-672-89088-1', '\'li', 'jquery', '5')
if($result){
    echo $db->affected_rows." book inserted into database.";//insert delect update都将用到这个变量或函数mysqli_affected_nows()
}else{
    echo "An error has occurred. The item was not added.";
}
$db->close();*/


//$query = "insert into books values(?,?,?,?)";//豫处理，防注入和批量秆入的场合
//$stmt = $db->prepare($query);////=mysqli_stmt_prepare()//返回一个mysqli_stmt对象\过程化样式：由 mysqli_stmt_init() 返回的 statement标识
//$stmt->bind_param("sssd",$isbn,$author,$title,$price);//=mysqli_stmt_bind_param() i整型d浮点s字符b二进制或包
//
//if($stmt->execute()) {//mysqli_stmt_execute($stmt);
//    echo $stmt->affected_rows . "book inserted into database";//大于零的整数表示受影响或检索的行数。零表示没有为UPDATE / DELETE语句更新的记录，没有与查询中的WHERE子句匹配的行，或者尚未执行任何查询。
//}else{echo '插入失败！';}
//$stmt->close();//关闭标识对象//mysqli_stmt_close($stmt);

$dsn = "mysql:host=localhost;dbname=books";//$dsn = 'mysql:dbname=testdb;host=127.0.0.1';
try {//建议使用PDO连接和操作数据库
    $db = new PDO($dsn, 'GuestL', 'cylinder',array(PDO::ATTR_PERSISTENT=>true));//持久性链接PDO::ATTR_PERSISTENT=>true
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    //$db->query();//一//主要是用于有记录结果返回的操作，特别是Select操作
    $db->exec('set names utf8');//二//PDO::exec()主要是针对没有结果集合返回的操作，比如Insert、Update、Delete等操作，它返回的结果是当前操作影响的列数。
}catch(PDOException $e){
    echo "Connection failed".$e->getMessage();
}
$sql = "insert into books values(:isbn,:author,:title,:price)";
$stmt = $db->prepare($sql);//三
if($stmt->execute(array(':isbn'=>$isbn,':author'=>$author,':title'=>$title,':price'=>$price))){
    //echo $stmt->affected_rows."book inserted into database";
    //echo $stmt->lastinsertid();
    echo $stmt->rowCount()."book inserted into database";
}else{echo '插入失败！';}
/*查询*/
/*$login = 'kevin%';
$sql = "SELECT * FROM `user` WHERE `login` LIKE :login";
$stmt = $dbh->prepare($sql);
$stmt->execute(array(':login'=>$login));
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    print_r($row);
}*/
/*PDO::FETCH_ASSOC -- 关联数组形式
PDO::FETCH_NUM   -- 数字索引数组形式
PDO::FETCH_BOTH  -- 两者数组形式都有，这是缺省的
PDO::FETCH_OBJ    -- 按照对象的形式，类似于以前的 mysql_fetch_object()*/
//PDO::lastInsertId()是返回上次插入操作，主键列类型是自增的最后的自增ID。
//PDOStatement::rowCount()主要是用于PDO::query()和PDO::prepare()进行Delete、Insert、Update操作影响的结果集，对PDO::exec()方法和Select操作无效
//事务
/*try {
    $dbh = new PDO('mysql:host=localhost;dbname=test', 'root', '');
    $dbh->query('set names utf8;');
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->beginTransaction();
    $dbh->exec("Insert INTO `test`.`table` (`name` ,`age`)VALUES ('mick', 22);");
    $dbh->exec("Insert INTO `test`.`table` (`name` ,`age`)VALUES ('lily', 29);");
    $dbh->exec("Insert INTO `test`.`table` (`name` ,`age`)VALUES ('susan', 21);");
    $dbh->commit();
} catch (Exception $e) {
    $dbh->rollBack();
    echo "Failed: " . $e->getMessage();
}*/
?>
</body>
</html>
