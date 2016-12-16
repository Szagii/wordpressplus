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
  $from = $request->input('from');
  $to = $request->input('to');
  $id =  $request->input('id');
  $slug = $request->input('slug');

    if(empty($request->input())){
      $results = app('db')->select(sprintf('SELECT * FROM wp_posts'));
    }
    else if(isset($from) && isset($to)){
      $results = app('db')->select('select * from wp_posts where post_date between :from AND :to', ['from' => $from, 'to' => $to]);
    }
    else
    {
      $results = app('db')->select('select * from wp_posts where id = :id OR post_name = :slug OR (post_date between :from AND NOW()) OR (post_date between :first_time AND :to)', ['id' => $request->input('id'), 'slug' => $request->input('slug'), 'from' => $from, 'to' => $to, 'first_time' => '1973-01-01 00:00:00']);
    }
      return $results;

});

    $app->get('/api/post', function(){
      $results = app('db')->select("SELECT * FROM wp_posts ORDER by ID ASC LIMIT 20"); 
      return $results;
    });

    $app->get('/api/posts/{page}', function($page){
      $results = app('db')->select("SELECT * FROM wp_posts ORDER by ID ASC LIMIT " . $page); 
      return $results;
    });



require __DIR__.'/wp-routes.php';
