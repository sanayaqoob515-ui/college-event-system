<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Certificate;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller {
    public function upload(Request $request) {
        $request->validate(['event_id'=>'required','student_id'=>'required','file'=>'required|file']);
        $path = $request->file('file')->store('certificates','public');
        Certificate::create([
            'event_id'=>$request->event_id,
            'student_id'=>$request->student_id,
            'certificate_url'=>$path
        ]);
        return back()->with('success','Certificate uploaded.');
    }
    public function myCertificates() {
        $certs = Certificate::where('student_id',Auth::id())->get();
        return view('certificates.my', compact('certs'));
    }
    public function payFee($id) {
        $cert = Certificate::where('id', $id)->where('student_id', Auth::id())->firstOrFail();
        $cert->fee_paid = true;
        $cert->save();
        return back()->with('success', 'Certificate fee marked as paid!');
    }
}
