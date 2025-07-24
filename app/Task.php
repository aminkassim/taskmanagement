<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $table = 'task';

    protected $fillable = ['id', 'title','description','status', 'created_at', 'updated_at'];

    public $timestamps = true;
    
    protected $primaryKey = 'id'; // or null

    public $incrementing = true;

}
