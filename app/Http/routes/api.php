<?php
Route::match(['get','post'],'/test', 'TestController@index');
Route::match(['get','post'],'/test/create', 'TestController@create');
Route::match(['get','post'],'/test/test', 'TestController@test');
Route::match(['get','post'],'/test/redistest', 'TestController@redistest');
//data_source 数据来原,json格式
//Route::match(['get','post'],'/api/getStarInfo/uid/pwd/star_id/{data_source?}', 'ApiController@getStarInfo');
Route::match(['get','post'],'/api/getStarInfo', 'ApiController@getStarInfo');
Route::match(['get','post'],'/api/sendMessage', 'ApiController@sendMessage');
Route::match(['get','post'],'/api/login', 'ApiController@login');
Route::match(['get','post'],'/api/test', 'ApiController@test');


