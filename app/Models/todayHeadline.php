<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class todayHeadline extends Model {

	//
    protected $table = 'today_headline';
    protected $fillable = [
        'star_id',
        'star_name',
        'title',
        'left_pic_urls',
        'nike_name',
        'publish_date',
        'video_flag',
        'created_at',
        'updated_at',
    ];
}
