<?php

namespace App\Helper;

use Illuminate\Support\Facades\Mail;

class MailHelper
{
    public static function base($mail, $name, $subject, $data, $view)
    {
        Mail::send($view, $data, function($message) use($mail, $name, $subject) {
            $message->to($mail, $name)->subject($subject);
        });
    }



}
