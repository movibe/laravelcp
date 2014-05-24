<?php namespace Gcphost\LaravelCP\Comment;

use Carbon,Input, Comment,DB;

class EloquentCommentRepository implements CommentRepository
{
	public $modelClassName="Todo";
	public $id;
	public $comment;

	public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

	public function createOrUpdate($id = null)
    {
        if(is_null($id))
		{
            $comment = new Comment;
        } else $comment = Comment::find($id);

        $comment->content = Input::get('content');
		$comment->save();
		if ( $comment->id ) $this->id=$comment->id;

		return $comment;
    }



	public function all(){
		return Comment::leftjoin('posts', 'posts.id', '=', 'comments.post_id')
                        ->leftjoin('users', 'users.id', '=','comments.user_id' )
                        ->select(array('comments.id as id', 'posts.id as postid','users.id as userid', 'comments.content', 'posts.title as post_name', 'users.displayname as poster_name', 'comments.created_at'));

	}

	public function find($id, $columns = array('*'))
	{
		return Comment::find($id);
	}
	
	public function delete($id)
	{
		return Comment::delete($id);
	}

	public function __call($method, $args)
    {
        return call_user_func_array([$this->comment, $method], $args);
    }

}