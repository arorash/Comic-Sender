<?php
include 'dbcon.php';

$msg = "";
if(isset($_POST['submit'])){
    if(isset($_POST['email'])){
        $email = mysqli_real_escape_string($con,$_POST['email']);
        if($email==""){
            $msg = "Enter the email.";
        }else{
            $email_check = "select * from registration where email='$email'";
            $query = mysqli_query($con,$email_check);
            $emailcount = mysqli_num_rows($query);
            if($emailcount>0){
                $msg = "Email already registered.";
            }else{
                $token = bin2hex(random_bytes(15));
                $insertquery = "insert into registration(email,token,status) values('$email','$token','inactive')";
                $iquery = mysqli_query($con,$insertquery);
                if($iquery){
                    $to_email = "$email";
                    $subject = "Verification Email";
                    $body = "Hi,<br> Click the link to verify the account:<br><br> <a href='http://localhost:7882/XKCD_Project/activate.php?token=$token'>Click Me</a> ";
                    $sender = "Content-type:text/html;charset=UTF-8" . "\r\n" . "From: shashankprofessional9@gmail.com";
                    if(mail($to_email,$subject,$body,$sender)){
                        $msg = "Verification link is send to $email";
                    }else{
                        $msg = "Some Error Occured.";
                    }
                }else{
                    $msg = "Some Error Occured";
                }
            }
        }


    }
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
        <p>Verify your email first to get comics.</p>
        <?php
            echo "<br><p style='color:green;'>$msg</p>";
        ?>

        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
            <input type="email" name="email" id="email" placeholder="Enter Your Email">
            <input type="number" name="otp" id="otp" style="margin-top: 10px;display:none;" placeholder="Enter The OTP">
            <button type="submit" style="display: none;" id="verify">Verify</button>
            <button type="submit" name="submit" id="send">Submit</button>
        </form>


    </div>

</body>
</html>