<?php
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
$app->get('/api/post', function(Request $request){
  $id =  $request->input('id');
  $slug = $request->input('slug');
  $from = $request->input('from');
  $to = $request->input('to');

    if(empty($request->input())){
      $results = app('db')->select(sprintf('SELECT * FROM wp_posts'));
    }
    else if(isset($from) && isset($to)){
      $results = app('db')->select(sprintf("SELECT * FROM wp_posts WHERE post_date BETWEEN %s AND %s", $from, $to));
    }
    else{
      $results = app('db')->select(sprintf("SELECT * FROM wp_posts WHERE %s=%s OR post_name=%s OR post_date BETWEEN %s AND NOW() OR post_date BETWEEN %s AND %s", $id, $slug, $from, $firts_time, $to));
    }
      return $results;
    
    
});
require __DIR__.'/wp-routes.php';
