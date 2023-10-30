<?php 

namespace app\model;

defined("ROOTPATH") OR exit("Access Denied");       

/**
 * 
 * Make sure to set the recipient, message from the instantiated object
 * 
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once "PHPMailer-master/src/Exception.php";
require_once "PHPMailer-master/src/PHPMailer.php";
require_once "PHPMailer-master/src/SMTP.php";

class Email
{
    public $recipient;
    public $subject;
    public $message;

    public $recipient_class_style;
    public $subject_class_style;
    public $message_class_style;
    public $btn_class_style;

    public $error = "";

    public function send_mail($recipient, $subject, $message)
    {
        
        // $mail = new PHPMailer();
        // $mail->IsSMTP();

        // $mail->SMTPDebug  = 0;
        // $mail->SMTPAuth   = TRUE;
        // $mail->SMTPSecure = "tls";
        // $mail->Port       = 587;
        // $mail->Host       = "smtp.gmail.com";
        // //$mail->Host       = "smtp.mail.yahoo.com";
        // $mail->Username   = "deepxchannel@gmail.com";
        // $mail->Password   = "lthcjlkdosythezd";
        
        // $mail->isHTML(true);
        // $mail->addAddress($recipient, "recipient-name");
        // $mail->setFrom("deepxchannel@gmail.com", "MyWebsite.com");
        // // $mail->addReplyTo("reply-to-email","reply-to-name");
        // // $mail->addCC("cc-recipient-email","cc-recipient-name");
        // $mail->Subject = $subject;
        // $content = $message;

        // $mail->msgHTML($content);
        // if (!$mail->send()) {
        //     echo "Error while sending Email";
        //     var_dump($mail);
        //     return false;
        // } else {
        //     echo "Email sent successfully";
        //     return true;
        // }

        $mail = new PHPMailer();
        $mail->IsSMTP();
    
        $mail->SMTPDebug  = 0;
        $mail->SMTPAuth   = TRUE;
        $mail->SMTPSecure = "ssl";
        $mail->Port       =  465;
        $mail->Host       = "smtp.gmail.com";
        //$mail->Host       = "smtp.mail.yahoo.com";
        $mail->Username   = "fortunenwohiri@gmail.com";
        $mail->Password   = "gbohajmvejstvfek";
        
        $mail->IsHTML(true);
        $mail->AddAddress($recipient, "recipient-name");
        $mail->SetFrom("fortunenwohiri@gmail.com", "ProInvest.com");
        // $mail->AddReplyTo("reply-to-email","reply-to-name");
        // $mail->AddCC("cc-recipient-email","cc-recipient-name");
        $mail->Subject = $subject;
        $content = $message;
    
        $mail->MsgHTML($content);
        if (!$mail->Send()) {
            // echo "Error while sending Email";
            // var_dump($mail);
            return false;
        } else {
            // echo "Email sent successfully";
            return true;
        }

    }

    public function valid_sendmail()
    {
        if (count($_POST) > 0) {
            
            //validate the variables
            if (empty($this->recipient)) {
                $this->error .= "Recipient name is required! <br>";
            }
            if (empty($this->subject)) {
                $this->error .= "Subject name is required! <br>";
            }
            if (empty($this->message )) {
                $this->error .= "Message to be sent is required! <br>";
            }

            //something was posted 

            // send_mail($recipient, $subject, $message);
            if ($this->error == "") {
                if ($this->send_mail($this->recipient, $this->subject, $this->message)) {
                    $this->error .= "Message sent! <br>";
                } else {
                    $this->error .= "Message not sent! <br>";
                }
            } else {
                return false;
            }

        }
    }

    public function view_form()
    { 
        ?>
            <form action="" method="post">
                <h3>Send Email</h3>
                <div>
                    <?php if (!empty($this->error)) {?>
                        <span style="color:red">
                            <?php echo $this->error; ?>
                        </span>
                    <?php }?>
                </div>
                <input type="text" name="email" placeholder="Recipient Email" class="<?=$this->recipient_class_style?>">
                <br>
                <input type="text" name="subject" placeholder="Subject" class="<?=$this->subject_class_style?>">
                <br>
                <textarea name="message" id="" cols="30" rows="10" class="<?=$this->message_class_style?>" ></textarea>
                <br>
                <input type="submit" name="submit" value="send" class="<?=$this->btn_class_style?>" >
            </form>
        <?php
    }
}