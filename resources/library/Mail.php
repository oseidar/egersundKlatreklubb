<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mail
 *
 * @author Idar
 */
include_once './resources/library/class.phpmailer.php';
include_once'./class.smtp.php';
class Mail {
   
    public $to,$from,$message,$subject;
    
    public $fromName; 
    
    function __construct($to, $from, $message, $subject) {
        print_r(getcwd());
        $this->to = $to;
        $this->from = $from;
        $this->message = $message;
        $this->subject = $subject;
        
        
        
    }
    
    public function send(){
        $mail = new PHPMailer();
        $mail->IsMail();
        $mail->Port = 587;
        $mail->Host = "smtp.domeneshop.no";
        $mail->SMTPAuth = true;
        $mail->Username = "post@egersundklatreklubb.no";
        $mail->Password =  "XKbp!q9y";

        $mail->From = "post@egersundklatreklubb.com";
        $mail->FromName = $this->fromName;
        $mail->AddAddress($this->to);
        $mail->Subject = $this->subject;
        $mail->Body = $this->message;
        $mail->AltBody = $this->message;
        if(!$mail->Send()){
            echo "Mailer error: " . $mail->ErrorInfo;
            return false;

        }
        else{
            return true;
        }
    }

}

?>
