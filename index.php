<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Netflix</title>
</head>
<body style="text-align:center;background-color:black;">
<h1 style="color:red;font-family:Impact, Charcoal, sans-serif;font-size:600%;"> Welcome to Netflix</h1>
<h3 style="color:snow;font-family:Arial Black, Gadget, sans-serif;font-size:250%;">It's time to start chilling...</h3>
<img src="Netflix-logo-and-screen.jpg" alt="netflix" style="width:1400px;">

<p style="color:snow;font-family:Arial Black, Gadget, sans-serif;font-size:170%;">Netflix, The world largest streaming service which offers online streaming of a library of films and television programs. <br>
    Available worldwide and distributes content from countries all over the globe. Could be in your home too.</p>

<a href="addMovie.php" target=_self" style="color:firebrick;font-family:Arial Black, Gadget, sans-serif;font-size:170%;">Add a new movie</a><br>
<a href="addFile.php" target="_self" style="color:firebrick;font-family:Arial Black, Gadget, sans-serif;font-size:170%;">Add a new file</a><br>
<br>
<br>
<br>

<?php
$server = "tcp:techniondbcourse01.database.windows.net,1433";
$user = "adilevi";
$pass = "Qwerty12!";
$database = "adilevi";
$c = array("Database" => $database, "UID" => $user, "PWD" => $pass);
sqlsrv_configure('WarningsReturnAsErrors', 0);
$conn = sqlsrv_connect($server, $c);
if($conn === false)
{
    echo "error";
    die(print_r(sqlsrv_errors(), true));
}
$sql="select n.release_year, n.title, n.duration
from Netflix n
where n.release_year in(select Top(10000000000000) release_year
                        from Netflix
                        where Netflix.country <> 'United States' and n.director not like '%,%'
                          and n.duration >= ALL(select duration
                                                from Netflix n1
                                                where Netflix.release_year = n1.release_year)
                        group by release_year)
order by (release_year) DESC;";

$result = sqlsrv_query($conn, $sql);
echo "<table border='1' style=color:snow; width=70% align=\"center\">";
echo "<tr><th>Year</th><th>Title</th><th>Duration</th></tr>";
while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    echo "<tr><td>".$row['release_year'] ."</td> <td>".$row['title']."</td> <td>".$row['duration']."</td></tr>";
}
echo "</table>";
?>


</body>
</html>


