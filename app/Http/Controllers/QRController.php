<?php
namespace App\Http\Controllers;
class QRController extends Controller {
    public function generate($id){ return response('QR code placeholder for registration '.$id); }
    public function scan(){ return view('qr.scan'); }
}
