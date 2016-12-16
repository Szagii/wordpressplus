<?php
class PostApiTest extends TestCase
{
	/** @test **/
	public function check_if_api_post_exist()
	{
	    $response = $this->call('GET', '/api/post');
	    $this->assertEquals(200, $response->status());
	}
	/** @test **/
	public function check_if_api_posts_exist()
	{
	    $response = $this->call('GET', '/api/posts');
	    $this->assertEquals(200, $response->status());
	}
	/** @test **/
	public function check_if_slug_exist_in_db()
	{	
		// Mam
		$slug = 'witaj-swiecie';
		// Sprawdzam czy jest w bazie
		$this->seeInDatabase( 'wp_posts', ['post_name' => $slug] );
		$data = app('db')->select("SELECT * FROM wp_posts WHERE ID = 1");
	}
	/** @test **/
	public function check_post_given_slug()
	{
		// Mam
		$slug = 'witaj-swiecie';
		$posts = app('db')->select("SELECT * FROM wp_posts WHERE post_name ='{$slug}'");
		// Wyświetlam wpis, wiedząc, że jest w bazie danych
		$this->visit('/api/post?slug=' . $slug);
		// Zwracanie na ekran treść wpisu ale jednocześnie wpis musi być w bazie
		$this->assertNotNull($posts);
		$this->see($slug);
	}
	/** @test **/
	public function check_if_id_exist_in_db()
	{
		// Mam
		$id = 1;
		// Sprawdzam czy jest w bazie
		$this->seeInDatabase('wp_posts', ['ID' => $id]);
		$data = app('db')->select("SELECT * FROM wp_posts WHERE ID=1");
	}
	/** @test **/
	public function check_post_given_id()
	{
		// Mam
		$slug = 'witaj-swiecie';
		$id = app('db')->select("SELECT * FROM wp_posts WHERE id='{slug}'");
		// Wyświetlam wpis, wiedząc, że jest w bazie danych
		$this->visit('/api/post?id=1');
		// Zwracanie na ekran treść wpisu ale jednocześnie wpis musi być w bazie
		$this->assertNotNull($id);
		$this->see($slug);
	}
	/** @test **/
	public function check_if_array_with_date_from_db_is_same_as_visit()
	{	
		// Mam
		$data = '2016-12-03 14:22:07';
		$data2 = '2016-12-05 07:48:59';
		$date = app('db')->select("SELECT * FROM wp_posts WHERE post_date BETWEEN '{data}' AND '{data2}'");
		// Wyświetlam wpis, wiedząc, że jest w bazie danych
		$this->visit('/api/post?from=2016-12-03%2014:22:07&to=2016-12-05%2007:48:59', $date);
	}
	/** @test **/
	public function check_if_api_posts_return_twenty_posts()
	{
		// Mam
		$limit = '20';
		$number = app('db')->select("SELECT * FROM wp_posts LIMIT $limit");
		// Wyświetlam wpis, wiedząc, że jest w bazie danych
		$this->visit('/api/post', $number);
	}
	/** @test **/
	public function check_if_api_posts_return_ten_posts()
	{
		// Mam
		$limit = '10';
		$number = app('db')->select("SELECT * FROM wp_posts LIMIT $limit");
		// Wyświetlam wpis, wiedząc, że jest w bazie danych
		$this->visit('/api/posts/10', $number);
	}
}