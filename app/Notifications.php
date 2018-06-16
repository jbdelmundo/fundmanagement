<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Mail;

class Notifications extends Model
{
    //
    $view_name = 'reminder'
    $data_view = ['user' => $user]
    Mail::send(
        $view_name, 
        $data_view,
        function ($m) use ($user) {
            //insert mail options here
            $m->to($user['email'])->subject('New Endorsement');
        }
    );

    //Other

    Mail::queue();

    Mail::raw('This is the body', function($message){
        $message->to();
        $message->from()
    });

    Mail::to($email_addr)
    ->send(new Mailable_obj())

     Mail::to($email_addr)
    ->queue(new Mailable_obj())
}
