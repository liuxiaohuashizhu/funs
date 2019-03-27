<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class user extends Model {

	protected $table = 'user';
    protected $fillable = [
        'user_name',
        'tel',
        'created_at',
        'updated_at',
    ];

}
