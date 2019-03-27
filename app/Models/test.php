<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class test extends Model {
    protected $table = 'test';
    protected $fillable = [
        'user_name',
        'user_pwd',
        'created_at',
        'updated_at',
    ];
}
