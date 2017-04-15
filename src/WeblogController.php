<?php

namespace Georgesdoe\Weblog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use Log;

class WeblogController extends Controller
{
    public function index(Request $request){
        $files = collect(Storage::disk('logs')->files());
        $files = $files
        ->filter(function($file){
            //Filter out hidden files (eg .gitignore)
            return strpos($file,'.') > 0; 
        })->map(function($file){
           return [
                'filename'=>$file,
                'size'=> $this->humanize(Storage::disk('logs')->size($file)),
                'updated'=>Storage::disk('logs')->lastModified($file),
            ];
        });
        if ($request->sort_order == "asc") {
            $files = $files->sortBy($request->input('sort_field','updated'));
        }else{
            $files = $files->sortByDesc($request->input('sort_field','updated'));
        }
        return view('weblog::index',compact('files'));
    }
    
    public function show(Request $request){
        $path = storage_path('logs')."/".$request->file;
        $file = new \SplFileObject($path);
        $iterator = new \LimitIterator($file, 0, 100);
        
        $result = "";
        foreach($iterator as $line) {

            $result .= "$line \n";
        }
        return view('weblog::show',['text'=>$result]);
    }
    
    public function download(Request $request){
        return response()->download(storage_path('logs')."/".$request->file);
    }
    
    public function delete(Request $request){
        Storage::disk('logs')->delete($request->file);
    }
    
    function humanize($bytes) {
        $sizes = ['B','KB','MB','GB','TB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        if (count($sizes) <= $factor) {
            $size = ">1024TB";
        }else{
            $size = $sizes[$factor];
        }
        return sprintf("%.2f", $bytes / pow(1024, $factor)) .$size;
    }
}
