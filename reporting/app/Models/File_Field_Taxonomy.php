<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB, Validator;

class File_Field_Taxonomy extends Model
{
    use SoftDeletes;
    protected $table = 'file_field_taxonomy_table';
    protected $primaryKey = 'id';
    protected $fillable = ['field_taxonomy_id', 'file_id'];
}
