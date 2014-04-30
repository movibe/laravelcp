<?php
use Illuminate\Filesystem\Filesystem;

class AdminBlogsController extends AdminController {


    /**
     * Post Model
     * @var Post
     */
    protected $post;

    /**
     * Inject the models.
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        parent::__construct();
        $this->post = $post;
    }


    /**
     * fetch template files
     *
     * @return Response
     */
	private function getPostTemplates(){
		$path=Config::get('view.paths');
		$fileSystem = new Filesystem;
		$files=$fileSystem->allFiles($path[0].DIRECTORY_SEPARATOR.Theme::getTheme().DIRECTORY_SEPARATOR.'site'.DIRECTORY_SEPARATOR.'layouts');
		return $files;
	}

    /**
     * get posts parents
     *
     * @return Response
     */
	private function getPostParents(){
		return array_merge(array('0'=>''),DB::table('posts')->orderBy('title', 'asc')->lists('title','id'));
	}

    /**
     * Show a list of all the blog posts.
     *
     * @return View
     */
    public function getIndex()
    {
        $posts = $this->post;
        $title = Lang::get('admin/blogs/title.blog_management');
        return Theme::make('admin/blogs/index', compact('posts', 'title'));
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		$templates=$this->getPostTemplates();
		$parents=$this->getPostParents();
        $title = Lang::get('admin/blogs/title.create_a_new_blog');
        return Theme::make('admin/blogs/create_edit', compact('title', 'templates', 'parents'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postCreate()
	{
        $rules = array(
            'title'   => 'required|min:3',
            'content' => 'required|min:3'
        );

		$validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Create a new blog post
            $user = Auth::user();

            // Update the blog post data
            $this->post->title            = Input::get('title');
            $this->post->slug             = Str::slug(Input::get('title'));
            $this->post->content          = Input::get('content');
            $this->post->meta_title       = Input::get('meta-title');
            $this->post->meta_description = Input::get('meta-description');
            $this->post->meta_keywords    = Input::get('meta-keywords');
            $this->post->user_id          = $user->id;

 			$this->post->banner			 = Input::get('banner');
            $this->post->display_author    = (int)Input::get('display_author');
            $this->post->allow_comments    = (int)Input::get('allow_comments');
            $this->post->template    = Input::get('template');
            $this->post->parent    = (int)Input::get('parent');
            $this->post->display_navigation    = (int)Input::get('display_navigation');

            if($this->post->save())
            {
                return Api::to(array('success', Lang::get('admin/blogs/messages.create.success'))) ? : Redirect::to('admin/slugs/' . $this->post->id . '/edit')->with('success', Lang::get('admin/blogs/messages.create.success'));
            } else return Api::to(array('error', Lang::get('admin/blogs/messages.create.error'))) ? : Redirect::to('admin/slugs/create')->with('error', Lang::get('admin/blogs/messages.create.error'));
        } else return Api::to(array('error', Lang::get('admin/blogs/messages.create.error'))) ? : Redirect::to('admin/slugs/create')->withInput()->withErrors($validator);
	}


    /**
     * Show the form for editing the specified resource.
     *
     * @param $post
     * @return Response
     */
	public function getEdit($post)
	{
        $title = Lang::get('admin/blogs/title.blog_update');
		$templates=$this->getPostTemplates();
		$parents=$this->getPostParents();
        return Theme::make('admin/blogs/create_edit', compact('post', 'title', 'templates', 'parents'));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param $post
     * @return Response
     */
	public function putEdit($post)
	{

        $rules = array(
            'title'   => 'required|min:3',
            'content' => 'required|min:3'
        );

        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            $post->title            = Input::get('title');
            $post->slug             = Str::slug(Input::get('title'));
            $post->content          = Input::get('content');
            $post->meta_title       = Input::get('meta-title');
            $post->meta_description = Input::get('meta-description');
            $post->meta_keywords    = Input::get('meta-keywords');
 			$post->banner			 = Input::get('banner');
            $post->display_author    = (int)Input::get('display_author');
            $post->allow_comments    = (int)Input::get('allow_comments');
            $post->template    = Input::get('template');
            $post->parent    = (int)Input::get('parent');
            $post->display_navigation    = (int)Input::get('display_navigation');

            return $post->save() ? Api::to(array('success', Lang::get('admin/blogs/messages.update.success'))) ? : Redirect::to('admin/slugs/' . $post->id . '/edit')->with('success', Lang::get('admin/blogs/messages.update.success')) : Api::to(array('error', Lang::get('admin/blogs/messages.update.error'))) ? : Redirect::to('admin/slugs/' . $post->id . '/edit')->with('error', Lang::get('admin/blogs/messages.update.error'));
        } else return Api::to(array('error', Lang::get('admin/blogs/messages.update.error'))) ? : Redirect::to('admin/slugs/' . $post->id . '/edit')->withInput()->withErrors($validator);
	}


    /**
     * Remove the specified resource from storage.
     *
     * @param $post
     * @return Response
     */
    public function deleteIndex($post)
    {
		$id = $post->id;
		$id = $post->id;
		if(!$post->delete()) return Api::json(array('result'=>'error', 'error' =>Lang::get('core.delete_error')));
		$post=Post::find($id);
        return empty($post) ? Api::json(array('result'=>'success')) : Api::json(array('result'=>'error', 'error' =>Lang::get('core.delete_error')));        
    }

    /**
     * Show a list of all the blog posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $posts = Post::select(array('posts.id', 'posts.title', 'posts.id as comments', 'posts.created_at'));

        if(Api::Enabled()){
			$u=$posts->get();
			return Api::make($u->toArray());
		} else return Datatables::of($posts)

        ->edit_column('comments', '{{ DB::table(\'comments\')->where(\'post_id\', \'=\', $id)->count() }}')

        ->add_column('actions', '<div class="btn-group"><a href="{{{ URL::to(\'admin/slugs/\' . $id . \'/edit\' ) }}}" class="btn btn-primary btn-sm modalfy" >{{{ Lang::get(\'button.edit\') }}}</a>
                <a data-method="delete" data-row="{{{  $id }}}" data-table="blogs"  href="{{{ URL::to(\'admin/slugs/\' . $id . \'\' ) }}}" class="ajax-alert-confirm btn btn-sm btn-danger">{{{ Lang::get(\'button.delete\') }}}</a></div>
            ')

        ->make();
    }

}