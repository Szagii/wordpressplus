<?php
class PostApiTest extends TestCase
{

	public function testPost()
	{
	    $response = $this->call('GET', '/api/post');
	    $this->assertEquals(200, $response->status());
	}
	public function testPosts()
	{
	    $response = $this->call('GET', '/api/posts');
	    $this->assertEquals(200, $response->status());
	}
	public function testSlug()
	{
		$this->seeInDatabase('wp_posts', ['post_name' => 'witaj-swiecie']);
		$data = app('db')->select("SELECT * FROM wp_posts WHERE ID = 1");
		$this->visit('/api/post?slug=witaj-swiecie', $data);
	}
	public function testId()
	{
		$this->seeInDatabase('wp_posts', ['post_name' => 'witaj-swiecie']);
		$data = app('db')->select("SELECT * FROM wp_posts WHERE post_name='witaj-swiecie'");
		$this->visit('/api/post?id=1', $data);
	}
	public function testDate()
	{
		$data = app('db')->select("SELECT * FROM wp_posts WHERE post_date BETWEEN '2016-12-03 14:22:07' AND '2016-12-05 07:48:59'");
		$this->visit('/api/post?from=2016-12-03%2014:22:07&to=2016-12-05%2007:48:59', $data);
	}

}