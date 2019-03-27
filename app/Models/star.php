<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class star extends Model {

	//
    protected $table = 'star';
    protected $fillable = [
        'star_name',
        'star_nike_name',
        'created_at',
        'updated_at',
    ];

}
