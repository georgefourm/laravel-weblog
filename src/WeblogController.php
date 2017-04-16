<?php

namespace Georgesdoe\Weblog;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
use Log;

class WeblogController extends Controller
{
    public function view(){
        return view('weblog::index');
    }
    
    public function data(Request $request){
        $files = 
        collect(Storage::disk('logs')->files())
        ->reject(function($value,$key){
            //Filter out hidden files
            return strpos($value,".") == 0;
        })
        ->map(function($file){
          return [
                'filename'=>$file,
                'size'=> Storage::disk('logs')->size($file),
                'last_modified'=>Storage::disk('logs')->lastModified($file),
            ];
        });
        
        if ($request->sort_order == "asc") {
            $files = $files->sortBy($request->input('sort_field','last_modified'));
        }else{
            $files = $files->sortByDesc($request->input('sort_field','last_modified'));
        }
        
        return response()->json($files->values());
    }
    
    public function show(Request $request){
        $path = storage_path('logs')."/".$request->file;
        $file = new \SplFileObject($path);
        $iterator = new \LimitIterator($file, 0, 100);
        
        $result = "";
        foreach($iterator as $line) {
            $result .= $line;
        }
        
        return view('weblog::show',['text'=>$result]);
    }
    
    public function stream(Request $request){
        
    }
    
    public function download(Request $request){
        if (!$this->check($request->file)) {
            return response()->json(['message'=>'Invalid File'],400);
        }
        return response()->download(storage_path('logs')."/".$request->file);
    }
    
    public function delete(Request $request){
        $filename = $request->file;
        if (!$this->check($filename)) {
            return response()->json(['message'=>'Invalid File'],400);
        }
        Storage::disk('logs')->delete($filename);
        return response()->json(['message'=>'File Deleted']);
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
    
    function check($file){
        return !Storage::disk('logs')->exists($file) || strpos($file,".") != 0;
    }
}
