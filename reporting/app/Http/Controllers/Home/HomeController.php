<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Excel;
use App\Models\File;
use App\Models\Field;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->columnTitles = [];
    }

    public function index() {

        $fields = Field::all();
        $fileTitles = File::distinct()->groupBy('parsed_title')->select('parsed_title')->get();
        $fileArray = [];
        foreach($fileTitles as $title) {
            $file = File::where('parsed_title', '=', $title->parsed_title)->select('parsed_date', 'full_title')->orderBy('parsed_date', 'desc');
            $fileData = $file->get();
                foreach($file->get() as $multiFile) {
                    $fileArray[$title->parsed_title][] = $multiFile;
                }
        }
        return view("home.index")->with('fileArray', $fileArray);
    }
    public function getFileRequest(Request $request) {
        $file = new File;
        $file->moveFile($request->file('file'));
    }
}