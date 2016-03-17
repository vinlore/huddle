<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User as User;
use App\Http\Controllers\Controller;

class MailController extends Controller
{
      /**
     * Send an email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    function sendCustomMail(/*$request*/){
       
    /*$to = $request->email;
    $subject = $request->subject;
    $body = $request->body;

    $user_id = $request->userId; */
    
    $email = 'gabrielahernandez@hotmail.ca';

    //$user = \Sentinel::findById($user_id);
   // if($user->notifications){

                //Send Email to User
            \Mail::send([], [], function ($message) use($email) {
                $message->to($email)
                ->subject('Vote for me.')
                ->setBody('Pls cote for me.');
            });

  //  }
      
    }

     function conferenceStatusEmail(/*$request*/){
       
    $to = $request->email;
    $subject = $request->subject;
    $body = $request->body;

    $user_id = $request->userId; 
    $status = $request->status;
    
    $email = 'gabrielahernandez@hotmail.ca';

    //$user = \Sentinel::findById($user_id);
   // if($user->notifications){
        

                //Send Email to User
            \Mail::send([], [], function ($message) use($email) {
                $message->to($email)
                ->subject('Vote for me.')
                ->setBody('Pls cote for me.');
            });

  //  }
      
    }

         function eventStatusEmail(/*$request*/){
       
    $to = $request->email;
    $subject = $request->subject;
    $body = $request->body;

    $user_id = $request->userId; 
    
    $email = 'gabrielahernandez@hotmail.ca';

    //$user = \Sentinel::findById($user_id);
   // if($user->notifications){
        

    

                //Send Email to User
            \Mail::send([], [], function ($message) use($email) {
                $message->to($email)
                ->subject('Vote for me.')
                ->setBody('Pls cote for me.');
            });

  //  }
      
    }

     function attendeeStatusEmail(/*$request*/){
       
    $to = $request->email;
    $subject = $request->subject;
    $body = $request->body;

    $user_id = $request->userId; 
    
    $email = 'gabrielahernandez@hotmail.ca';

    //$user = \Sentinel::findById($user_id);
   // if($user->notifications){
        

    

                //Send Email to User
            \Mail::send([], [], function ($message) use($email) {
                $message->to($email)
                ->subject('Vote for me.')
                ->setBody('Pls cote for me.');
            });

  //  }
      
    }
    
}
