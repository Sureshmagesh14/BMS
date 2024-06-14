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
        
        if ($this->data['type'] == 'new_register') {
            return $this->view('mail.new_account')
                ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->replyTo(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->subject($this->data['subject']);
        } elseif ($this->data['type'] == 'new_project') {
            return $this->view('mail.new_survey')
                ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->replyTo(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->subject($this->data['subject'])
                ->with(['project' => $this->data['project']]);
        } else {
            return $this->view('mail.new_survey')
                ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->replyTo(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->subject($this->data['subject'])
                ->with(['test_message' => $this->data['message']]);
        }
    }
    
}