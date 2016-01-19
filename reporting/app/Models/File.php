<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB, Validator;
use Excel;

class File extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    protected $fillable = ['full_title', 'parsed_title', 'parsed_date', 'file_ext', 'uploaded_by'];

    public function user() {
        return $this->belongsTo('App\User', 'uploaded_by', 'id');
    }

    public function file_field_taxonomy() {
        return $this->belongsTo('App\Models\File_Field_Taxonomy', 'file_id', 'id');
    }

    private function createFileRecord($file) {
        //create the path
        $fileName = base_path() . '/public/files/' . $file->getClientOriginalName();
        $fileArr = explode(".", $file->getClientOriginalName());
        $fileTitleArr = explode("_", $fileArr[0]);

        //create the necessary fields
        $fileUpload = new File(['full_title' => $fileArr[0], 'parsed_title' => $fileTitleArr[0], 'parsed_date' => $fileTitleArr[1], 'file_ext' => $fileArr[1]]);

        //get the current userID into
        $user = User::find(\Auth::user()->id);
        //save the file using the user model
        $fileUpload = $user->file()->save($fileUpload);

        //if the file uploaded and saved
        //pull the headers from the file
        if($fileUpload) {
            $this->saveHeaders($file, $fileUpload->id);
        }
    }

    private function saveHeaders($file, $fileID) {
        //create the path
        $fileName = base_path() . "/public/files/" . $file->getClientOriginalName();
        //create the empty arrays
        $columnTitles = [];
        $taxonomyArray = [];
        $fieldArray = [];
        //load the file
        $rows = Excel::load($fileName, function($reader) {})->get();

        //set the values of the columns as the header
        foreach($rows as $title => $value) {
            //set the row data
            foreach($value as $key => $column) {
                $columnTitles[$key][] = $column;
            }
        }
        $files = File::find($fileID);

        foreach($columnTitles as $key => $value) {
            $field_tax = Field_Taxonomy::where('title', '=', $key);
            $fieldTaxID = 0;
            $count = 1;
            //if the title doesn't exist as a record in the field_tax table
            if($field_tax->count() === 0) {
                //grab the id of the newly inserted taxonomy record
                $fieldTaxID = Field_Taxonomy::insertGetId(['title' => $key]);
                foreach($value as $data) {
                    Field::insert(['value' => $data, 'field_taxonomy_id' => $fieldTaxID, 'row_in_file' => $count]);
                    $count++;
                }
                    File_Field_Taxonomy::insert(['file_id' => $fileID, 'field_taxonomy_id' => $fieldTaxID]);
            } else {
                $fileArr = explode(".", $file->getClientOriginalName());
                $fileTitleArr = explode("_", $fileArr[0]);
                $fieldTax = Field_Taxonomy::take(1)
                    ->select('field_taxonomy_table.id')
                    ->join('file_field_taxonomy_table', 'file_field_taxonomy_table.field_taxonomy_id', '=', 'field_taxonomy_table.id')
                    ->join('files', 'files.id', '=', 'file_field_taxonomy_table.file_id')
                    ->where('title', '=', $key)
                    ->where('parsed_title', '=', $fileTitleArr[0])->get();
                if(count($fieldTax) > 0) {
                    $fieldTaxID = $fieldTax[0]->id;
                } else {
                    $fieldTaxID = Field_Taxonomy::insertGetId(['title' => $key]);
                }
                foreach($value as $data) {
                    Field::insert(['value' => $data, 'field_taxonomy_id' => $fieldTaxID, 'row_in_file' => $count]);
                    $count++;
                }
                File_Field_Taxonomy::insert(['file_id' => $fileID, 'field_taxonomy_id' => $fieldTaxID]);
            }
        }
    }

    public function moveFile($file) {
        //move the file
        if($file->move(base_path() . '/public/files/', $file->getClientOriginalName())) {
            $this->createFileRecord($file);
        }
    }
}
