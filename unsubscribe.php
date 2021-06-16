<?php
    include 'dbcon.php';
    $msg = "";
    if(isset($_GET['token'])){
        $token = $_GET['token'];
        $checkquery = "select * from registration where token='$token' and status='unsubscribe'";
        $cquery = mysqli_query($con,$checkquery);
        if(mysqli_num_rows($cquery)>0){
            $msg = "This link is not valid now.";
        }else{
            $updatequery = "update registration set status='unsubscribe' where token='$token' ";
            $uquery = mysqli_query($con,$updatequery);
            if($uquery){
                $msg = "You have successfully unsubscribed.";
            }else{
                $msg = "Some Error Occured.";
            }
        }

    }else{
        $msg="Link is not valid.";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>XKCD Comic</title>

</head>
<body>
    <div class="container">
        <h3>XKCD Comics</h3>

        <?php
            echo "<br><p style='color:white;background-color:green'>$msg</p>";
        ?>


    </div>

</body>
</html>