# Comic-Sender

This is a simple PHP application with HTML,CSS. This application accept email of user and after verification of email, they gets random comics from xkcd-comic. If user want to stop getting these comics via email, they can unsubscribed. Since this is a simple project it must be done in core PHP including API calls, recurring emails, including attachments.

### Live Demo

[Click Here](https://xckd-comic-project.herokuapp.com/)

### Device Supported

* Laptop/PC
* Mobile Devices like iPhone/Android

## The project have mainly 4 steps:

### Register User

* User come on application should enter their email and submit the form.
* For each user unique token is created though which we can active or unsubscribed the user.
* The data is also stored in MySQL database. 

### Verification of email

* User get verification link via email on their registered email id.
* User should click that link to verify the registered id and after that user get verified or status become active and link should become invaild.
* After verification user get comics via email with an attachment of comic as an image.

### How to send random comics

* Use [JSON API](https://xkcd.com/json.html) of xkcd-comic, to get [Current Comic](http://xkcd.com/info.0.json) details and [Random Comic](http://xkcd.com/614/info.0.json) detail where '614' represent the comic number-614.
* Then send the email to the active or subscribed user with title, inline image and unsubscribe button to stop getting these comics in HTML format and an attachment of same comic as an image.
* These comics goes after every 5 minutes to all the active user so I use Cron Job Scheduler on Heroku that help me to run these command after every 5 minutes.

### Unsubscribe the user

* To stop getting these comics, user should click the unsubscribe link given in every comic. On clicking that link user status become unsubscribe and stop getting these comics.
* Link also become invalid after use. 

## How to send emails:

* By using PHPMailer : Create PHPMailer Object by ($mail = new PHPMailer();)
* Host should be "smtp.google.com" : set the host by ($mail->Host = 'smtp.gmail.com';)
* Port should be 465 : set the port by ($mail->Port = 465;)
* Give your email credentials though which you want to send emails : $mail->Username = 'your email'; $mail->Password = 'your email password'; 
* Email should have valid subject : set the subject by ($mail->Subject = 'New Subject';)
* Email should support HTML format : Enable HTML by ($mail->isHTML(true);)
* Email should have valid body : set the body by ($mail->Body ='New Body';)
* send() function is used to send : $mail->send();

