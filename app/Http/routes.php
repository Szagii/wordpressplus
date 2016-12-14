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
  		$results = app('db')->select(sprintf('SELECT * FROM wp_posts WHERE post_date BETWEEN :from AND :to', ['from'=>$from, 'to'=>$to]));
  	}
  	else{
  		$results = app('db')->select(sprintf('SELECT * FROM wp_posts WHERE id=:id OR post_name=:slug OR post_date BETWEEN :from AND NOW() OR post_date BETWEEN :first_time AND :to', 
      ['id' => $request->input(sprintf('id')), 'slug' => $request->input(sprintf('slug')), 'from'=>$from, 'to'=>$to, 'first_time'=>'1973-01-01 00:00:00']));
  	}

    while($results == true){
      return $results;
    }

});

require __DIR__.'/wp-routes.php';

