<?php


class Email{

private $emailTo = null;

private $subject = null;

private $body = null;


private $headers = array();

public function __construct($to, $subject)
{
    $this->emailTo = $to;
    $this->subject = $subject;


    $this->headers[] = 'MIME-Version: 1.0';
    $this->headers[] = 'Content-type: text/html; charset=iso-8859-1';

    // Additional headers
    $this->headers[] = 'To: <'.$this->emailTo.'>';
    $this->headers[] = 'From: Modeling database <noreply@modeling.oldersma.org>';



}

public function setMessage($body){
    $this->body = $body;
}


public function sendMail(){
    if($this->emailTo !== null && $this->subject !== null && $this->body !== null){
        mail ($this->emailTo, $this->subject, $this->body, implode("\r\n", $this->headers));
    }

    else{
        throw new Exception("Niet alle velden goed ingevuld. Mail niet verzonden");
    }
}

}

?>