<?php

function send_email($email,$name,$subject,$message)
{
    $ci = get_instance();
    $ci->load->library('email');
    $ci->email->from($email, $name);
    $ci->email->to('frentsel@mail.ru');
    $ci->email->subject($subject);

    $text = $ci->load->view('email/message',array('message'=>$message,'name'=>$name),true);

    $ci->email->message($text);

    $ci->email->send();
}

function send_order($email,$subject,$order)
{
    $ci = get_instance();
    $ci->load->library('email');
    $ci->email->from(base_url(), 'Admin');
    $ci->email->to($email.',frentsel@mail.ru');
    $ci->email->subject($subject);

    $text = $ci->load->view('email/order',array('cart'=>$order),true);

    $ci->email->message($text);

    $ci->email->send();
}