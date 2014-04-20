<?php

return array(
 
    'driver' => 'smtp',
 
    'host' => 'smtp.gmail.com',
 
    'port' => 587,
 
    'from' => array('address' => '', 'name' => 'Awesome Laravel 4 Auth App'),
 
    'encryption' => 'tls',
 
    'username' => '',
 
    'password' => '',
 
    'sendmail' => '/usr/sbin/sendmail -bs',
 
    'pretend' => false,
 
);

?>
