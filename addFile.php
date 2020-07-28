<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add File</title>
</head>
<body style="text-align:center;background-color:black;" >
<h1 style="color:red;font-family:Impact, Charcoal, sans-serif;font-size:500%;">Add File</h1>
<h2 style="color:white ;font-family:Impact white, Gadget, sans-serif;font-size:250%;"> Choose File:</h2><br><br>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data" style="color:white">

    <input  name="csv" type="file" id="csv" style="color:white" /><br><br>
    <input  type="submit" name="submit" value="submit" cols="30" />
</form>
<?php
if (isset($_POST["submit"])){
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
    $countS=0;
    $countF=-1; //we can assume that every csv file have header according to coral
    $file = $_FILES[csv][tmp_name];
    if (($handle = fopen($file, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $sql="INSERT INTO Netflix (title, director,cast,country,release_year, duration,listed_in) VALUES
                    ('" . addslashes($data[0]) . "','" . addslashes($data[1]) . "','" . addslashes($data[2]) ."',
                    '" . addslashes($data[3]) . "'," . addslashes($data[4]) . "," . addslashes($data[5]) . ",'" . addslashes($data[6]) . "');";
            $result = sqlsrv_query($conn, $sql);
            if ($result){
                $countS++;
            }
            else{
                $countF++;
                }
        }
        echo "<span style=\"color:snow;text-align:center;\"> Number of rows that were added to the database successfully: ".$countS."<br></span>'";
        echo "<span style=\"color:snow;text-align:center;\"> Number of rows that were'nt added to the database: ".$countF."<br></span>'";

        fclose($handle);
    }
}
?>
<body >
</body>
</html>
