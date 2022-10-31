<?php

namespace App\Listeners;

use App\Events\SendEmailEvent;
use App\Mail\NewsletterMail;
use App\Models\News;
use App\Models\Newsletter;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmailListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\SendEmailEvent  $event
     * @return void
     */
    public function handle(SendEmailEvent $event)
    {
        //
        $email=Newsletter::get('email','link');
        
       foreach($email as $mailing){
        Mail::to($mailing)->send(new NewsletterMail($event->name,$event->link));
      }
    }
}