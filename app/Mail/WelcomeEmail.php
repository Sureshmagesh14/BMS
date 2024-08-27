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
            //completed

            return $this->view('mail.new_account')
                ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->replyTo(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->subject($this->data['subject']);

        } elseif ($this->data['type'] == 'new_project') {
            //completed

            return $this->view('mail.new_survey')
                ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->replyTo(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->subject($this->data['subject'])
                ->with(['project' => $this->data['project'],'name' => $this->data['name']]);

        }elseif ($this->data['type'] == 'project_notification') {
            //completed

            return $this->view('mail.notify_survey')
                ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->replyTo(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->subject($this->data['subject'])
                ->with(['project' => $this->data['project'],'proj_content'=> $this->data['proj_content'] ,'name' => $this->data['name'],'reward' => $this->data['reward'],'survey_duration' => $this->data['survey_duration']]);

        }elseif ($this->data['type'] == 'reward_approve') {
            //completed

            return $this->view('mail.reward_approved')
                ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->replyTo(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->subject($this->data['subject'])
                ->with(['project' => $this->data['project'],'name' => $this->data['name']]);

        }elseif ($this->data['type'] == 'cash_create') {
            //not completed

            return $this->view('mail.cashout_created')
                ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->replyTo(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->subject($this->data['subject'])
                ->with(['name' => $this->data['name']]);

        }elseif ($this->data['type'] == 'confirm_account') {
            //not completed

            return $this->view('mail.confirm_account')
                ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->replyTo(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->subject($this->data['subject'])
                ->with(['fullname' => $this->data['fullname'],'url' => $this->data['url']]);

        }elseif ($this->data['type'] == 'email_confirm') {
            //not completed

            return $this->view('mail.email_confirmed')
                ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->replyTo(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->subject($this->data['subject'])
                ->with(['fullname' => $this->data['fullname']]);

        }elseif ($this->data['type'] == 'forgot_password') {
            //not completed
            
            return $this->view('mail.forgot_password')
                ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->replyTo(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->subject($this->data['subject'])
                ->with(['otp' => $this->data['otp']]);

        } 
        elseif ($this->data['type'] == 'mobile_change_otp') {

            return $this->view('mail.email_otp_mobile_change')
                ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->replyTo(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->subject($this->data['subject'])
                ->with(['otp' => $this->data['otp']]);
        }
        else {

            return $this->view('mail.new_survey')
                ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->replyTo(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                ->subject($this->data['subject'])
                ->with(['test_message' => $this->data['message']]);

        }
    }
    
}