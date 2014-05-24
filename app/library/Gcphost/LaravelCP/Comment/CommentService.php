<?php 
use Gcphost\LaravelCP\Comment\CommentRepository as Comment;

class CommentService {
    protected $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
    public function index()
    {
        $comments = $this->comment;
        return Theme::make('admin/comments/index', compact('comments'));
    }

	public function getEdit($comment)
	{
        return Theme::make('admin/comments/edit', compact('comment'));
	}

	public function edit($comment)
	{
		$save=$this->comment->createOrUpdate($comment->id);
		$errors = $save->errors();

		return count($errors->all()) == 0 ?
			(Api::to(array('success', Lang::get('admin/comments/messages.update.success'))) ? : Redirect::to('admin/comments/' . $comment->id . '/edit')->with('success', Lang::get('admin/comments/messages.update.success'))) :
			(Api::to(array('error', Lang::get('admin/comments/messages.update.error'))) ? : Redirect::to('admin/comments/' . $comment->id . '/edit')->withErrors($errors));
	}

	public function delete($comment)
	{
		return $comment->delete() ? 
			Api::json(array('result'=>'success')) : 
			Api::json(array('result'=>'error', 'error' =>Lang::get('core.delete_error')));
	}

	public function page($limit=10){
		return $this->comment->paginate($limit);
	}

    public function get()
    {
		if(Api::Enabled()){
			return Api::make($this->comment->all()->get()->toArray());
		} else return Datatables::of($this->comment->all())
        ->edit_column('content', '<a href="{{{ URL::to(\'admin/comments/\'. $id .\'/edit\') }}}" class="modalfy cboxElement">{{{ Str::limit($content, 40, \'...\') }}}</a>')
        ->edit_column('post_name', '<a href="{{{ URL::to(\'admin/slugs/\'. $postid .\'/edit\') }}}" class="modalfy cboxElement">{{{ Str::limit($post_name, 40, \'...\') }}}</a>')
        ->edit_column('poster_name', '<a href="{{{ URL::to(\'admin/users/\'. $userid .\'/edit\') }}}" class="modalfy cboxElement">{{{ $poster_name }}}</a>')
        ->add_column('actions', '
			 <div class="btn-group btn-hover">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					  <span class="fa fa-lg fa-cog fa-fw"></span>
					  <span class="caret"></span>
				</button>
				<ul class="dropdown-menu pull-right" role="menu">
					<li><a href="{{{ URL::to(\'admin/comments/\' . $id . \'/edit\' ) }}}" class="modalfy ">{{{ Lang::get(\'button.edit\') }}}</a></li>
					<li class="divider"></li>
					<li><a data-row="{{{  $id }}}" data-method="delete" data-table="comments" href="{{{ URL::to(\'admin/comments/\' . $id . \'\' ) }}}" class="confirm-ajax-update ">{{{ Lang::get(\'button.delete\') }}}</a></li>
				</ul>
			</div>
		')
        ->remove_column('postid')
        ->remove_column('userid')
        ->make();
    }

}