<?php
    include 'dbcon.php';

    $url1 = "http://xkcd.com/info.0.json";
    $json1 = file_get_contents($url1);
    $json1 = json_decode($json1);
    $max = $json1->num;
    $num = rand(1,$max);
    $url = "https://xkcd.com/"."$num"."/info.0.json";
    $json2 = file_get_contents($url);
    $json2 = json_decode($json2);

    $semi_rand = md5(time());
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

    $sub = "Comic - ".$json2->title;

    $image = "Content-Type: application/octet-stream; name=\"".basename($json2->img)."\"\n" .
        "Content-Description: ".basename($json2->img)."\n" .
        "Content-Disposition: attachment;\n" . " filename=\"".basename($json2->img)."\"; \n" .
        "Content-Transfer-Encoding: base64\n\n" . chunk_split(base64_encode(file_get_contents($json2->img))) . "\n\n";

    $sender = "From: shashankprofessional9@gmail.com";
    $sender .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";

    $selectquery = "select * from registration where status='active'";
    $squery = mysqli_query($con,$selectquery);

    while($row = mysqli_fetch_assoc($squery)){
        $to_ = $row['email'];
        $to = "$to_";
        $token = $row['token'];
        $body = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
        "Content-Transfer-Encoding: 7bit\n\n" ."Title : ".$json2->title. " <br><br> <img src='".$json2->img."' /><br><br>If you want to stop getting these comics, please click the below link: <br><a href='http://localhost:7882/XKCD_Project/unsubscribe.php?token=$token''>Unsubscribe</a> ". "\n\n";
        $body .= "--{$mime_boundary}\n";
        $body .= $image;

        if(mail($to,$sub,$body,$sender)){
            echo "sent";
        }else{
            echo "failed";
        }
    }


?>