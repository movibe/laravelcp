<?php 
use Illuminate\Filesystem\Filesystem;
use Gcphost\LaravelCP\Blog\BlogRepository as Post;

class BlogService {
    protected $post;

	public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function index()
    {
        $posts = $this->post;
        return Theme::make('admin/blogs/index', compact('posts'));
    }

	public function getCreate()
	{
		$templates=$this->post->templates();
		$parents=$this->post->parents();
        return Theme::make('admin/blogs/create_edit', compact('templates', 'parents'));
	}

	public function create()
	{

		$save=$this->post->createOrUpdate();
		$errors = $save->errors();

		return count($errors->all()) == 0 ?
			(Api::to(array('success', Lang::get('admin/blogs/messages.create.success'))) ? : Redirect::to('admin/slugs/' . $this->post->id . '/edit')->with('success', Lang::get('admin/blogs/messages.create.success'))) :
			(Api::to(array('error', Lang::get('admin/blogs/messages.create.error'))) ? : Redirect::to('admin/slugs/create')->withErrors($errors));
	}

	public function getEdit($post)
	{
		$templates=$this->post->templates();
		$parents=$this->post->parents();
        return Theme::make('admin/blogs/create_edit', compact('post', 'templates', 'parents'));
	}

	public function edit($post)
	{
		$save=$this->post->createOrUpdate($post->id);
		$errors = $save->errors();

		return count($errors->all()) == 0 ?
			(Api::to(array('success', Lang::get('admin/blogs/messages.update.success'))) ? : Redirect::to('admin/slugs/' . $post->id . '/edit')->with('success', Lang::get('admin/blogs/messages.update.success'))) :
			(Api::to(array('error', Lang::get('admin/blogs/messages.update.error'))) ? : Redirect::to('admin/slugs/' . $post->id . '/edit')->withErrors( $errors));
	}

    public function delete($post)
    {
		return $post->delete() ? 
			Api::json(array('result'=>'success')) :
			Api::json(array('result'=>'error', 'error' =>Lang::get('core.delete_error')));
    }

	public function page($limit=10){
		return $this->post->paginate($limit);
	}

	public function get()
    {
		if(Api::Enabled()){
			return Api::make($this->post->all()->get()->toArray());
		} else return Datatables::of($this->post->all())
		->edit_column('title', '<a href="{{{ URL::to(\'admin/slugs/\' . $id . \'/edit\' ) }}}" class="modalfy">{{{$title}}}</a>')
        ->edit_column('comments', '{{ DB::table(\'comments\')->where(\'post_id\', \'=\', $id)->count() }}')
        ->add_column('actions', '
			 <div class="btn-group btn-hover">
				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
					  <span class="fa fa-lg fa-cog fa-fw"></span>
					  <span class="caret"></span>
				</button>
				<ul class="dropdown-menu pull-right" role="menu">
					<li><a href="{{{ URL::to(\'admin/slugs/\' . $id . \'/edit\' ) }}}" class="modalfy" >{{{ Lang::get(\'button.edit\') }}}</a></li>
					<li class="divider"></li>
					<li><a data-method="delete" data-row="{{{  $id }}}" data-table="blogs" href="{{{ URL::to(\'admin/slugs/\' . $id . \'\' ) }}}" class="confirm-ajax-update ">{{{ Lang::get(\'button.delete\') }}}</a></li>
				</ul>
			</div>
            ')
        ->make();
    }

}