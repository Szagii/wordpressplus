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

$app->get('/api/posts/{page}', function($page){
  $results = app('db')->select("SELECT * FROM wp_posts ORDER by ID ASC LIMIT " . $page); 
  return $results;
});

$app->get('/api/posts', function(){
  $results = app('db')->select("SELECT * FROM wp_posts ORDER by ID ASC LIMIT 20"); 
  return $results;
});

$app->get('/api/deletepost', function(Request $request){
  $id = $request->input('id');
  $results = app('db')->delete('DELETE * FROM wp_posts WHERE ID = :ID', ['ID' => $id]);
  return $results;
});

$app->get('/api/addpost', function(Request $request){
  $title = $request->input('title');
  $content = $request->input('content');
  $post_name = $request->input("post_name");
  $results = app('db')->insert("INSERT INTO wp_posts (post_content, post_title, post_name) VALUES (:content, :title, :name)", ['content' => $content, 'title' => $title, 'name' => $post_name]);
});


$app->get('/api/editpost', function(Request $request){
  $post_name = $request->input('post_name');
  $title = $request->input('title');
  $content = $request->input('content');
  $id = $request->input('id');
    if(isset($post_name) && isset($title) && isset($content) &&  isset($id))
    {
      $results = app('db')->update("UPDATE wp_posts SET post_title = :post_title, post_name = :post_name, post_content = :post_content WHERE ID = :id", ['post_name' => $post_name, 'post_content' => $content, 'post_title' => $title, 'id' => $id]);
    }
    if(isset($content) && $id)
    {
    $results = app('db')->update("UPDATE wp_posts SET post_content = :post_content WHERE ID = :id", ['post_content' => $content, 'id' => $id]);
    }
    if(isset($title) && $id)
    {
    $results = app('db')->update("UPDATE wp_posts SET post_title = :post_title WHERE ID = :id", ['post_title' => $title, 'id' => $id]);   
    }
    if(isset($post_name) && $id)
    {
      $results = app('db')->update("UPDATE wp_posts SET post_name = :post_name WHERE ID = :id", ['post_name' => $post_name, 'id' => $id]);
    }
  });

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



require __DIR__.'/wp-routes.php';
