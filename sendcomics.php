<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require_once __DIR__ .'/PHPMailer/PHPMailer.php';
    require_once __DIR__ .'/PHPMailer/SMTP.php';
    require_once __DIR__ .'/PHPMailer/Exception.php';

    include __DIR__ .'/dbcon.php';

    $url1 = 'http://xkcd.com/info.0.json';
    $json1 = file_get_contents($url1);
    $json1 = json_decode($json1);
    $max = $json1->num;
    $num = rand(1,$max);
    $url = 'https://xkcd.com/'."$num".'/info.0.json';
    $json2 = file_get_contents($url);
    $json2 = json_decode($json2);


    $selectquery = 'select * from registration where status="active"';
    $squery = mysqli_query($con,$selectquery);

    while($row = mysqli_fetch_assoc($squery)){
        $to_ = $row['email'];
        $token = $row['token'];
        $href = 'http://'.$_SERVER['HTTP_HOST'].'/unsubscribe.php?token='.$token;
        $subject = 'Comic -' .$json2->title;
        $body = "Title : ".$json2->title. " <br><br> <img src='".$json2->img."' /><br><br>If you want to stop getting these comics, please click the below link: <br><a href='$href'>Unsubscribe</a> ";

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = getenv('EMAIL_ID');
        $mail->Password = getenv('EMAIL_PASS');
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->isHTML(true);
        $mail->From = getenv('EMAIL_ID');
        $mail->FromName = 'XCKD COMIC PROJECT';
        $mail->addAddress("$to_");
        $mail->Subject = $subject;
        $mail->Body =$body;

        $mail->addStringAttachment(file_get_contents($json2->img), basename($json2->img),'base64', 'application/octet-stream');

        try{
            $mail->send();
            echo 'sent';
        }catch(Exception $e){
            echo 'Error occured.';
        }
    }



?>