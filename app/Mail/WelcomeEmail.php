<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        //dd($this->data);
        
        if($this->data=='new_register'){

            return $this->view('mail.new_account')
                    ->from(env('mail_from_address'), env('MAIL_FROM_NAME'))
                    ->replyTo(env('mail_from_address'),env('MAIL_FROM_NAME'))
                    ->subject($this->data['subject']);

        }else if($this->data=='new_project'){

            

            return $this->view('mail.new_survey')
                    ->from(env('mail_from_address'), env('MAIL_FROM_NAME'))
                    ->replyTo(env('mail_from_address'),env('MAIL_FROM_NAME'))
                    ->subject($this->data['subject'])
                    ->with(['project'=>$this->data['project']]);

        }else{

        
            return $this->view('mail.new_survey')
                    ->from(env('mail_from_address'), env('MAIL_FROM_NAME'))
                    ->replyTo(env('mail_from_address'),env('MAIL_FROM_NAME'))
                    ->subject($this->data['subject'])
                    ->with([ 'test_message' => $this->data['message'] ]);
        }
    }
    
}