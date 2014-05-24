<?php namespace Gcphost\LaravelCP\Blog;

use Carbon,Input, Str, Auth, Post,DB;

class EloquentBlogRepository implements BlogRepository
{
	public $modelClassName="Post";
	public $id;

	public function __construct(Post $post)
    {
        $this->post = $post;
    }

	public function createOrUpdate($id = null)
    {
        if(is_null($id))
		{
            $post = new Post;
        } else $post = Post::find($id);

		$post->title            = Input::get('title');
		$post->slug             = Str::slug(Input::get('title'));
		$post->content          = Input::get('content');
		$post->meta_title       = Input::get('meta-title');
		$post->meta_description = Input::get('meta-description');
		$post->meta_keywords    = Input::get('meta-keywords');
		$post->user_id          = Auth::user()->id;
		$post->banner			 = Input::get('banner');
		$post->display_author    = (int)Input::get('display_author');
		$post->allow_comments    = (int)Input::get('allow_comments');
		$post->template    = Input::get('template');
		$post->parent    = (int)Input::get('parent');
		$post->display_navigation    = (int)Input::get('display_navigation');
		$post->updateUniques();
		if ( $post->id ) $this->id=$post->id;

		return $post;
    }

	public function all(){
		return Post::select(array('posts.id', 'posts.title', 'posts.id as comments', 'posts.created_at'));
	}

	public function getpost($slug){
		return $this->where('slug', '=', $slug)->first();
	}

	public function find($id, $columns = array('*'))
	{
		return Post::find($id);
	}
	
	public function delete($id)
	{
		return Post::delete($id);
	}

	public function __call($method, $args)
    {
        return call_user_func_array([$this->post, $method], $args);
    }
}