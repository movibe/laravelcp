<?php

class AdminCommentsController extends AdminController
{
    protected $comment;
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
    public function getIndex()
    {
        $comments = $this->comment;
        return Theme::make('admin/comments/index', compact('comments'));
    }

	public function getEdit($comment)
	{
        return Theme::make('admin/comments/edit', compact('comment'));
	}

	public function putEdit($comment)
	{
        $rules = array(
            'content' => 'required|min:3'
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes())
        {
            $comment->content = Input::get('content');

            if($comment->save())
            {
                return Api::to(array('success', Lang::get('admin/comments/messages.update.success'))) ? : Redirect::to('admin/comments/' . $comment->id . '/edit')->with('success', Lang::get('admin/comments/messages.update.success'));
            } else return Api::to(array('error', Lang::get('admin/comments/messages.update.error'))) ? : Redirect::to('admin/comments/' . $comment->id . '/edit')->with('error', Lang::get('admin/comments/messages.update.error'));
        } else return Api::to(array('error', Lang::get('admin/comments/messages.update.error'))) ? : Redirect::to('admin/comments/' . $comment->id . '/edit')->withInput()->withErrors($validator);
	}

	public function deleteIndex($comment)
	{
		$id = $comment->id;
		if(!$comment->delete()) return Api::json(array('result'=>'error', 'error' =>Lang::get('core.delete_error')));
		$comment=Comment::find($id);
        return empty($comment) ? Api::json(array('result'=>'success')) : Api::json(array('result'=>'error', 'error' =>Lang::get('core.delete_error')));        
	}

    public function getData()
    {
        $comments = Comment::leftjoin('posts', 'posts.id', '=', 'comments.post_id')
                        ->leftjoin('users', 'users.id', '=','comments.user_id' )
                        ->select(array('comments.id as id', 'posts.id as postid','users.id as userid', 'comments.content', 'posts.title as post_name', 'users.displayname as poster_name', 'comments.created_at'));

        if(Api::Enabled()){
			$u=$comments->get();
			return Api::make($u->toArray());
		} else return Datatables::of($comments)

        ->edit_column('content', '<a href="{{{ URL::to(\'admin/comments/\'. $id .\'/edit\') }}}" class="modalfy cboxElement">{{{ Str::limit($content, 40, \'...\') }}}</a>')

        ->edit_column('post_name', '<a href="{{{ URL::to(\'admin/slugs/\'. $postid .\'/edit\') }}}" class="modalfy cboxElement">{{{ Str::limit($post_name, 40, \'...\') }}}</a>')

        ->edit_column('poster_name', '<a href="{{{ URL::to(\'admin/users/\'. $userid .\'/edit\') }}}" class="modalfy cboxElement">{{{ $poster_name }}}</a>')

        ->add_column('actions', '<div class="btn-group"><a href="{{{ URL::to(\'admin/comments/\' . $id . \'/edit\' ) }}}" class="modalfy btn btn-primary btn-sm">{{{ Lang::get(\'button.edit\') }}}</a>
                <a data-row="{{{  $id }}}" data-method="delete" data-table="comments" href="{{{ URL::to(\'admin/comments/\' . $id . \'\' ) }}}" class="confirm-ajax-update btn btn-sm btn-danger">{{{ Lang::get(\'button.delete\') }}}</a></div>
            ')

        ->remove_column('postid')
        ->remove_column('userid')

        ->make();
    }

}
