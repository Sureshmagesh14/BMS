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
        $address = 'smartvijay@gmail.com';
        $subject = 'This is a demo!';
        $name = 'Jane Doe';

        return $this->view('admin.emails.welcome')
                    ->from($address, $name)
                    ->cc($address, $name)
                    ->bcc($address, $name)
                    ->replyTo($address, $name)
                    ->subject($subject)
                    // ->with([ 'id' => $this->data['id'] ])
                    ->with([ 'test_message' => $this->data['message'] ]);
    }
   
    
}