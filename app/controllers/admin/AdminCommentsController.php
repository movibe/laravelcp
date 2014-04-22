<?php

class AdminCommentsController extends AdminController
{

    /**
     * Comment Model
     * @var Comment
     */
    protected $comment;

    /**
     * Inject the models.
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        parent::__construct();
        $this->comment = $comment;
    }

    /**
     * Show a list of all the comment posts.
     *
     * @return View
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/comments/title.comment_management');

        // Grab all the comment posts
        $comments = $this->comment;

        // Show the page
        return View::make('admin/comments/index', compact('comments', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $comment
     * @return Response
     */
	public function getEdit($comment)
	{
        // Title
        $title = Lang::get('admin/comments/title.comment_update');

        // Show the page
        return View::make('admin/comments/edit', compact('comment', 'title'));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param $comment
     * @return Response
     */
	public function postEdit($comment)
	{
        // Declare the rules for the form validation
        $rules = array(
            'content' => 'required|min:3'
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Update the comment post data
            $comment->content = Input::get('content');

            // Was the comment post updated?
            if($comment->save())
            {
                // Redirect to the new comment post page
                return Redirect::to('admin/comments/' . $comment->id . '/edit')->with('success', Lang::get('admin/comments/messages.update.success'));
            }

            // Redirect to the comments post management page
            return Redirect::to('admin/comments/' . $comment->id . '/edit')->with('error', Lang::get('admin/comments/messages.update.error'));
        }

        // Form validation failed
        return Redirect::to('admin/comments/' . $comment->id . '/edit')->withInput()->withErrors($validator);
	}


    /**
     * Remove the specified resource from storage.
     *
     * @param $comment
     * @return Response
     */
	public function postDelete($comment)
	{


		$id = $comment->id;
		$comment->delete();

		$comment = Comment::find($id);
		if(empty($comment)){
			return Response::json(array('result'=>'success'));
		} else return Response::json(array('result'=>'failure', 'error' =>Lang::get('admin/comments/messages.delete.error')));
        
	}

    /**
     * Show a list of all the comments formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $comments = Comment::leftjoin('posts', 'posts.id', '=', 'comments.post_id')
                        ->leftjoin('users', 'users.id', '=','comments.user_id' )
                        ->select(array('comments.id as id', 'posts.id as postid','users.id as userid', 'comments.content', 'posts.title as post_name', 'users.displayname as poster_name', 'comments.created_at'));

        return Datatables::of($comments)

        ->edit_column('content', '<a href="{{{ URL::to(\'admin/comments/\'. $id .\'/edit\') }}}" class="modalfy cboxElement">{{{ Str::limit($content, 40, \'...\') }}}</a>')

        ->edit_column('post_name', '<a href="{{{ URL::to(\'admin/slugs/\'. $postid .\'/edit\') }}}" class="modalfy cboxElement">{{{ Str::limit($post_name, 40, \'...\') }}}</a>')

        ->edit_column('poster_name', '<a href="{{{ URL::to(\'admin/users/\'. $userid .\'/edit\') }}}" class="modalfy cboxElement">{{{ $poster_name }}}</a>')

        ->add_column('actions', '<div class="btn-group"><a href="{{{ URL::to(\'admin/comments/\' . $id . \'/edit\' ) }}}" class="modalfy btn btn-primary btn-sm">{{{ Lang::get(\'button.edit\') }}}</a>
                <a  data-row="{{{  $id }}}" data-table="comments" href="{{{ URL::to(\'admin/comments/\' . $id . \'/delete\' ) }}}" class="ajax-alert-confirm btn btn-sm btn-danger">{{{ Lang::get(\'button.delete\') }}}</a></div>
            ')

        ->remove_column('postid')
        ->remove_column('userid')

        ->make();
    }

}
