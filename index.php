<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ .'/PHPMailer/PHPMailer.php';
require_once __DIR__ .'/PHPMailer/SMTP.php';
require_once __DIR__ .'/PHPMailer/Exception.php';

include __DIR__ .'/dbcon.php';

$msg = '';
if(isset($_POST['submit'])){
    if(isset($_POST['email'])){
        $email = mysqli_real_escape_string($con,$_POST['email']);
        if($email==''){
            $msg = 'Enter the email.';
        }else{
            $email_check = "select * from registration where email='$email'";
            $query = mysqli_query($con,$email_check);
            $emailcount = mysqli_num_rows($query);
            if($emailcount>0){
                $msg = 'Email already registered.';
            }else{
                $token = bin2hex(random_bytes(15));
                $insertquery = "insert into registration(email,token,status) values('$email','$token','inactive')";
                $iquery = mysqli_query($con,$insertquery);
                if($iquery){

                    $subject = 'Verification Email';
                    $href = 'http://'.$_SERVER['HTTP_HOST'].'/activate.php?token='.$token;
                    echo $href;

                    $body = "Hi,<br> Click the link to verify the account:<br><br> <a href='$href'>Click Me</a> ";

                    $mail = new PHPMailer();
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'shashankprofessional9@gmail.com';
                    $mail->Password = 'Sha1Sha2nk@78';
                    $mail->Port = 465;
                    $mail->SMTPSecure = 'ssl';
                    $mail->isHTML(true);
                    $mail->From = 'shashankprofessional9@gmail.com';
                    $mail->FromName = 'XCKD COMIC PROJECT';
                    $mail->addAddress("$email");
                    $mail->Subject = $subject;
                    $mail->Body =$body;
                    try{
                        $mail->send();
                        $msg = "Verification link send to $email";
                    }catch(Exception $e){
                        $msg = 'Error occured.';
                    }
                }else{
                    $msg = 'Some Error Occured';
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