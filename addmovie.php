<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Movie</title>
</head>
<body style="text-align:center;background-color:black" >
<h1 style="color:red;font-family:Impact, Charcoal, sans-serif;font-size:500%;">New movie</h1>
<h3 style="color:white;font-family:Impact, Charcoal, sans-serif;font-size:300%;">Fill Movie Details</h3>
<h5 style="color:white;font-family:Impact, Charcoal, sans-serif;font-size:100%;">range</h5>

<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
    <table border="0" cellpadding="5" style="margin-left:auto; color:white; margin-right:auto;">
        <tr><td> Title:</td><td> <textarea name="Title" rows="2" required="required" pattern="[A-Za-z]{2,}"></textarea></td></tr>
        <tr><td> Director:</td><td> <textarea name="Director" rows="2" required="required" pattern="[A-Za-z]{2,}"></textarea></td></tr>
        <tr><td> Cast:</td><td> <textarea name="Cast" rows="2" ></textarea></td></tr>
        <tr><td> Country:</td><td> <textarea name="Country" rows="2" required="required" pattern="[A-Za-z]{2,}"></textarea></td></tr>
        <tr><td> ReleaseYear:</td><td> <input type="number" name="Release Year" rows="2" cols="20" min="1900" max="2020"></td></tr>
        <tr><td> Duration:</td><td> <input type="range" name="Duration" min="20" max="200"> </td></tr>
        <tr><td> ListedIn:</td><td> <textarea name="Listed in" rows="2" ></textarea></td></tr>
    </table><br>
    <button  type="submit" name="submit" value="Send"> Send</button><br><br>
    <button  type="reset" value="Clear"> reset</button>
</form>

<?php
if (isset($_POST["submit"])){
    echo("the movie was added to the DB successfully");
    $server = "tcp:techniondbcourse01.database.windows.net,1433";
    $user = "adilevi";
    $pass = "Qwerty12!";
    $database = "adilevi";
    $c = array("Database" => $database, "UID" => $user, "PWD" => $pass);
    sqlsrv_configure('WarningsReturnAsErrors', 0);
    $conn = sqlsrv_connect($server, $c);
    if($conn === false){
        echo "error";
        die(print_r(sqlsrv_errors(), true));
    }
    $sql = "INSERT INTO  Netflix(title, director,cast,country,release_year, duration,listed_in)
    VALUES ('".$_POST['Title']."','".$_POST['Director']."','".$_POST['Cast']."','".$_POST['Country']."',
    '".$_POST['ReleaseYear']."','".$_POST['Duration']."','".$_POST['Listed in']."');";
    $result = sqlsrv_query($conn, $sql);
		if (!$result) {
			die("<span style=\"color:snow;text-align:center;\">Couldn't add the part to the catalog.<br></span>'");
		}
		echo "<span style=\"color:snow;text-align:center;\">The details have been added to the database.<br><br></span>'";
}
?>
</body>
</html>
