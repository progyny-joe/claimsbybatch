<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB, Validator;

class Field extends Model
{
    use SoftDeletes;
    protected $table = 'fields';
    protected $primaryKey = 'id';
    protected $fillable = ['value', 'field_taxonomy_id', 'row_in_file'];

    public function field_taxonomy() {
        return $this->belongsTo('App\Models\Field_Taxonomy', 'field_taxonomy_id', 'id');
    }
}
