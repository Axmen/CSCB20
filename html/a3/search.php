<html>
<head><title>My Movie Database (MyMDb)</title>
<link href="https://mathlab.utsc.utoronto.ca/courses/cscb20w13/rosselet/asn/a3/img/favicon.png" type="image/png" rel="shortcut icon" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>
<script type='text/javascript' src='mymdb.js'></script>
<link href="mymdb.css" type="text/css" rel="stylesheet" />
</head>
<?include "top.html" ?>

<?include "bottom.html" ?>
<div id="main">
<?php
  $first_name=$_REQUEST['firstname'];
  $last_name=$_REQUEST['lastname'];
  $cb=$_REQUEST['check'];
?>

<h1> Results for <?=$first_name . " "?> <?=$last_name?> </h1>
<?
if ($cb == "true")
{
  ?>Films with and <?=$first_name . " "?> <?=$last_name . " and "?> Kevin Bacon<?
  $sql =  'select m1.name, m1.year from movies as m1,roles as r1,roles as r2,actors as a1,actors as a2 where m1.id = r1.movie_id and m1.id = r2.movie_id and a1.id = r1.actor_id and a2.id = r2.actor_id and a1.id = (select id from actors where first_name="'.$first_name.'" and last_name="'.$last_name.'") and a2.first_name = "Kevin" and a2.last_name = "Bacon";'; 
}
else
{
  $sql = "select movies.name, movies.year, actors.id from actors inner join roles on actors.id=roles.actor_id inner join movies on movies.id=roles.movie_id where actors.last_name='" . $last_name . "' and actors.first_name='" . $first_name . "';";
}
try {
  $dbh = new PDO("mysql:host=mathlab.utsc.utoronto.ca;dbname=imdb", "nunesrol", "mOnty#18");
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $dbh->query($sql);  
  $runs = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $dbh = null;
  } 
  catch(PDOException $e) { 
}
include 'config.php';

if ((count($runs) == 0) and ($cb == "true")){
  echo("<h3>" . $first_name . " " . $last_name . " and Kevin Bacon have no movies in common! </h3>");
}
else if (count($runs) == 0){
  echo("<h3>There are no films of " . $first_name . " " . $last_name . " in our database.</h3>");
}
else{
  ?>
  <table id="table" align="center" width="80%">
    <tr><th>#</th> <th align="center" width="93%">Title</th> <th>Year</th></tr>
  <?
  $count = 1;
  if (count($runs) > 0)
  {
    foreach ($runs as $i)
    {
      if ($count%2 == 1)
      {
        ?><tr bgcolor="#BDBDBD"> <?
      }
      else
      {
        ?><tr bgcolor="white"><?
      }
      ?>
      
        <td><?=$count?></td>
        <td align="center"><? echo($i["name"]); ?> </td> 
        <td> <? echo($i["year"]);?></td>
      </tr> <?
      $count++;
    }  
  }
  ?>
  </table>
  <?
}

?>

</div>

</html>