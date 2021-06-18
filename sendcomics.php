<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require_once "PHPMailer/PHPMailer.php";
    require_once "PHPMailer/SMTP.php";
    require_once "PHPMailer/Exception.php";

    include 'dbcon.php';

    $url1 = "http://xkcd.com/info.0.json";
    $json1 = file_get_contents($url1);
    $json1 = json_decode($json1);
    $max = $json1->num;
    $num = rand(1,$max);
    $url = "https://xkcd.com/"."$num"."/info.0.json";
    $json2 = file_get_contents($url);
    $json2 = json_decode($json2);


    $selectquery = "select * from registration where status='active'";
    $squery = mysqli_query($con,$selectquery);

    while($row = mysqli_fetch_assoc($squery)){
        $to_ = $row['email'];
        $token = $row['token'];
        $subject = "Comic - $json2->title";
        $body = "Title : ".$json2->title. " <br><br> <img src='".$json2->img."' /><br><br>If you want to stop getting these comics, please click the below link: <br><a href='https://xckd-comic-project.herokuapp.com/unsubscribe.php?token=$token''>Unsubscribe</a> ";

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "shashankprofessional9@gmail.com";
        $mail->Password = "Sha1Sha2nk@78";
        $mail->Port = 465;
        $mail->SMTPSecure = "ssl";
        $mail->isHTML(true);
        $mail->From = "shashankprofessional9@gmail.com";
        $mail->FromName = "XCKD COMIC PROJECT";
        $mail->addAddress("$to_");
        $mail->Subject = $subject;
        $mail->Body =$body;

        $mail->addStringAttachment(file_get_contents($json2->img), basename($json2->img),'base64', 'application/octet-stream');

        try{
            $mail->send();
            echo "sent";
        }catch(Exception $e){
            echo "Error occured.";
        }
    }



?>