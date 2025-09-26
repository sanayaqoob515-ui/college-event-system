<?php
namespace App\Mail;
use Illuminate\Mail\Mailable;
class GenericMail extends Mailable {
    public $content;
    public function __construct($content){$this->content=$content;}
    public function build(){return $this->subject('EventSphere Notification')->view('emails.generic');}
}
