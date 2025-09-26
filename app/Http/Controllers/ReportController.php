<?php
namespace App\Http\Controllers;
use App\Models\Event;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller {
    public function exportCSV() {
        $events = Event::all();
        $csv = "id,title,date,venue\n";
        foreach($events as $e){
            $csv .= "$e->id,$e->title,$e->date,$e->venue\n";
        }
        return Response::make($csv,200,[
            'Content-Type'=>'text/csv',
            'Content-Disposition'=>'attachment; filename="events.csv"'
        ]);
    }
}
