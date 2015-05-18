<?php
$firstname=$_REQUEST['firstname'];
$lastname=$_REQUEST['lastname'];
$sql = "select * from actors where first_name like '%".$firstname."%' and last_name like '%".$lastname."%';";
try {
  $dbh = new PDO("mysql:host=mathlab.utsc.utoronto.ca;dbname=imdb", "nunesrol", "mOnty#18");
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $dbh->query($sql);  
  $runs = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $dbh = null;
  } 
  catch(PDOException $e) { 
}  
echo json_encode($runs);
?>