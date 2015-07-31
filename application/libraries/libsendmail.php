<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class libsendmail  {
    
    function statusEmail($to, $realname, $from){
            $subject = 'Dinua | Status baru untukmu dari '.$realname.'! '; // Give the email a subject
            $message = '
Hai '.$realname.'
'.$from.' mengrim status pada dinding kamu,
silahkan masuk ke http://dinua.net untuk melihat dan balas status teman kamu

Terimakasih atas partisipasi Kamu'; // Our message above including the link
                
                $headers = 'From:dinua-noreply@dinua.net' . "\r\n"; // Set from headers
                mail($to, $subject, $message, $headers); // Send our email

    }
    
    function commentEmail($to, $realname, $from, $type){
            $subject = 'Dinua | '.$type.' kamu mendapatkan komentar! '; // Give the email a subject
            $message = '
Hai '.$realname.'
'.$from.' membuat komentar pada salah satu '.$type.' kamu!
silahkan masuk ke http://dinua.net untuk melihat dan balas komentar teman kamu

Terimakasih atas partisipasi Kamu'; // Our message above including the link
                
                $headers = 'From:dinua-noreply@dinua.net' . "\r\n"; // Set from headers
                mail($to, $subject, $message, $headers); // Send our email

    }
    
    function messageEmail($to, $realname, $from){
            $subject = 'Dinua | Kamu memiliki pesan baru dari '.$realname.'! '; // Give the email a subject
            $message = '
Hai '.$realname.'
'.$from.' mengirim sebuah pesan untuk kamu!
silahkan masuk ke http://dinua.net untuk melihat dan balas pesan teman kamu

Terimakasih atas partisipasi Kamu'; // Our message above including the link
                
                $headers = 'From:dinua-noreply@dinua.net' . "\r\n"; // Set from headers
                mail($to, $subject, $message, $headers); // Send our email

    }
    
    function friendReqEmail($to, $realname, $from){
            $subject = 'Dinua | '.$realname.' menambahkanmu menjadi teman, ayo terima permintaanya! '; // Give the email a subject
            $message = '
Hai '.$realname.'
'.$from.' memintamu menjadi teman
silahkan masuk ke http://dinua.net untuk menerima dan terhubung dengan teman baru kamu

Terimakasih atas partisipasi Kamu'; // Our message above including the link
                
                $headers = 'From:dinua-noreply@dinua.net' . "\r\n"; // Set from headers
                mail($to, $subject, $message, $headers); // Send our email

    }
}