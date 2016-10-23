<html>
<head>
    <title>Book-O-Rama Search Results</title>
</head>
<body>
<?php
$searchtype = $_POST['searchtype'];
$searchterm = trim($_POST['searchterm']);
if(!$searchtype || !$searchterm){
    echo 'You have not entered search details.!1 please go back and try again.';
    exit;
}
//echo 'str'.ini_get('extension_dir');
 //if(PHP_VERSION >= 6 || !get_magic_quotes_gpc){//get_magic_quotes_gpc()PHP5.4已经移除
    $searchtype = addslashes($searchtype);//PHP提供!
    $searchterm = addslashes($searchterm);
    //$searchtype = mysqli_real_escape_string($searchtype);//数据库提供推荐
 //}

/*$link = mysqli_connect('localhost', 'my_user', 'my_password', 'my_db');

if (!$link) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
        . mysqli_connect_error());
}*/
//$db = mysqli_connect()
//mysqli_free_result($result);
//mysqli_close($con);
 @ $db = new mysqli('localhost','GuestL','cylinder','books');
/*if($db->connect_errno){
    die('Connect Error (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}*/
if(mysqli_connect_errno()){
    echo 'Error: Could not connect to database. please try again later.';
    exit;
}
$query = "select * from books where ".$searchtype." like '%".$searchterm."%'";//弄了半天SQL LIKE搞错了，ECHO测试
echo $query;
$result = $db->query($query);
$num_results = $result->num_rows;
echo "<p>Number of books found:".$num_results."</p>";
for($i=0; $i<$num_results; $i++){
    $row = $result->fetch_assoc();
    echo "<p><strong>".($i+1)."Title: ";
    echo htmlspecialchars(stripslashes($row['title']));
    echo "</strong><br>Author: ";
    echo stripslashes($row['author']);
    echo "<br>ISBN: ";
    echo stripslashes($row['isbn']);
    echo "<br>Price: ";
    echo stripslashes($row['price']);
    echo "</p>";
}
$result->free();
$db->close();
?>
</body>
</html>

