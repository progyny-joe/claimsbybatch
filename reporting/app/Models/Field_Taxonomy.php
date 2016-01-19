<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB, Validator;

class Field_Taxonomy extends Model
{
    use SoftDeletes;
    protected $table = 'field_taxonomy_table';
    protected $primaryKey = 'id';
    protected $fillable = ['title'];

    public function file_field_taxonomy() {
        return $this->belongsTo('App\Models\File_Field_Taxonomy', 'file_id', 'id');
    }

    public function field() {
        return $this->hasMany('App\Models\Field', 'field_taxonomy_id', 'id');
    }
}