<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Verifyme extends Mailable
{
    use Queueable, SerializesModels;
    public $ema;
    public $sub;
    public $dat;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject,$email,$data)
    {
        $this->ema=$email;
        $this->sub=$subject;
        $this->dat=$data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $e_mail = $this->ema;
        $e_subject = $this->sub;
        $data =$this->dat;
        $send=$this->from('itkeyzzpianny1998@gmail.com','Websoft-pay')->subject($e_subject)
        ->view('emails.verify',compact('data'));
        return $send;
    }
}
