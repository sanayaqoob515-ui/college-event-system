<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller {
    public function index(Request $request) {
        $query = Media::orderBy('created_at','desc');
        $selectedCategory = $request->category;
        $selectedSubcategory = $request->subcategory;
        if ($selectedSubcategory) {
            $query->where('subcategory_id', $selectedSubcategory);
        } elseif ($selectedCategory) {
            $query->whereHas('subcategory', function($q) use ($selectedCategory) {
                $q->where('gallery_category_id', $selectedCategory);
            });
        }
        $media = $query->get();
        $categories = \App\Models\GalleryCategory::with('subcategories')->get();
        return view('gallery.index', compact('media','categories','selectedCategory','selectedSubcategory'));
    }
    public function showUploadForm() {
        $categories = \App\Models\GalleryCategory::with('subcategories')->get();
        return view('gallery.upload', compact('categories'));
    }
    public function upload(Request $request) {
        $request->validate([
            'event_id'=>'required',
            'file'=>'required|file',
            'subcategory_id'=>'nullable|exists:gallery_subcategories,id',
        ]);
        $path = $request->file('file')->store('uploads','public');
        Media::create([
            'event_id'=>$request->event_id,
            'file_type'=>$request->file('file')->getClientOriginalExtension(),
            'file_url'=>$path,
            'caption'=>$request->caption,
            'uploaded_by'=>Auth::id(),
            'subcategory_id'=>$request->subcategory_id,
        ]);
        return back()->with('success','Media uploaded.');
    }
}
