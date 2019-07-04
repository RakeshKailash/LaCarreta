<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'protocol' => 'smtp', // 'mail', 'sendmail', or 'smtp'
    'smtp_host' => 'smtp.hostinger.com', 
    'smtp_port' => 587,
    'smtp_user' => 'formulario@lacarretapanchos.com.br',
    'smtp_pass' => 'cNo8xH!;l=~C#oIN;x',
    'smtp_crypto' => 'tls', //can be 'ssl' or 'tls' for example
    'mailtype' => 'html', //plaintext 'text' mails or 'html'
    'smtp_timeout' => '4', //in seconds
    'charset' => 'utf-8',
    'wordwrap' => TRUE,
    'to' => 'marcelo.boemeke@gmail.com'
);