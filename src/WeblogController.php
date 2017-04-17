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
        $files = Storage::disk('logs')->files();
        $per_page = $request->input('page_size',5);
        
        $files = collect($files)
        ->reject(function($value,$key){
            //Filter out hidden files
            return strpos($value,".") == 0;
        });
        
        $total = $files->count();
        $files = $files
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
        
        $files = $files->forPage($request->input('page',1),$per_page);
        
        $result = [
            'files' => $files->values(),
            'total' => $total,
            'per_page' => $per_page,
            'current_page' => $request->input('page',1)
        ];
        return response()->json($result);
    }
    
    public function show(Request $request){
        if (!$this->check($request->file)) {
            return response()->json(['message'=>'Invalid File'],400);
        }
        return view('weblog::show',['text'=>Storage::disk('logs')->get($request->file)]);
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
    
    function check($file){
        return !Storage::disk('logs')->exists($file) || strpos($file,".") != 0;
    }
}
