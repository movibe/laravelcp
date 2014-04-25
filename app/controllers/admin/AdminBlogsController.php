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



	private function getPostTemplates(){
		$path=Config::get('view.paths');
		$fileSystem = new Filesystem;
		$files=$fileSystem->allFiles($path[0].DIRECTORY_SEPARATOR.'site'.DIRECTORY_SEPARATOR.'layouts');
		return $files;
	}
	private function getPostParents(){
		// return Post::select(array('posts.id', 'posts.title'))->get();
		return array_merge(array('0'=>''),DB::table('posts')->orderBy('title', 'asc')->lists('title','id'));
	}

    /**
     * Show a list of all the blog posts.
     *
     * @return View
     */
    public function getIndex()
    {
        // Title
        $title = Lang::get('admin/blogs/title.blog_management');

        // Grab all the blog posts
        $posts = $this->post;

        // Show the page
        return View::make('admin/blogs/index', compact('posts', 'title'));
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
        // Title
        $title = Lang::get('admin/blogs/title.create_a_new_blog');
		$templates=$this->getPostTemplates();
		$parents=$this->getPostParents();

        // Show the page
        return View::make('admin/blogs/create_edit', compact('title', 'templates', 'parents'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function postCreate()
	{
        // Declare the rules for the form validation
        $rules = array(
            'title'   => 'required|min:3',
            'content' => 'required|min:3'
        );
        // Validate the inputs
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

 			$this->banner			 = Input::get('banner');
            $this->display_author    = (int)Input::get('display_author');
            $this->allow_comments    = (int)Input::get('allow_comments');
            $this->template    = Input::get('template');
            $this->parent    = (int)Input::get('parent');
            $this->display_navigation    = (int)Input::get('display_navigation');

		   // Was the blog post created?
            if($this->post->save())
            {
                // Redirect to the new blog post page
                return Redirect::to('admin/slugs/' . $this->post->id . '/edit')->with('success', Lang::get('admin/blogs/messages.create.success'));
            }

            // Redirect to the blog post create page
            return Redirect::to('admin/slugs/create')->with('error', Lang::get('admin/blogs/messages.create.error'));
        }

        // Form validation failed
        return Redirect::to('admin/slugs/create')->withInput()->withErrors($validator);
	}


    /**
     * Show the form for editing the specified resource.
     *
     * @param $post
     * @return Response
     */
	public function getEdit($post)
	{
        // Title
        $title = Lang::get('admin/blogs/title.blog_update');
		$templates=$this->getPostTemplates();
		$parents=$this->getPostParents();

		// Show the page
        return View::make('admin/blogs/create_edit', compact('post', 'title', 'templates', 'parents'));
	}

    /**
     * Update the specified resource in storage.
     *
     * @param $post
     * @return Response
     */
	public function putEdit($post)
	{

   // Declare the rules for the form validation
        $rules = array(
            'title'   => 'required|min:3',
            'content' => 'required|min:3'
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {
            // Update the blog post data
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

			// Was the blog post updated?
            if($post->save())
            {
                // Redirect to the new blog post page
                return Redirect::to('admin/slugs/' . $post->id . '/edit')->with('success', Lang::get('admin/blogs/messages.update.success'));
            }

            // Redirect to the blogs post management page
            return Redirect::to('admin/slugs/' . $post->id . '/edit')->with('error', Lang::get('admin/blogs/messages.update.error'));
        }

        // Form validation failed
        return Redirect::to('admin/slugs/' . $post->id . '/edit')->withInput()->withErrors($validator);
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
		$post->delete();

		$post = Post::find($id);
		if(empty($post)){
		  return Response::json(array('result'=>'success'));
		} else return Response::json(array('result'=>'failure', 'error' =>Lang::get('admin/blogs/messages.delete.error')));

    }

    /**
     * Show a list of all the blog posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $posts = Post::select(array('posts.id', 'posts.title', 'posts.id as comments', 'posts.created_at'));

        return Datatables::of($posts)

        ->edit_column('comments', '{{ DB::table(\'comments\')->where(\'post_id\', \'=\', $id)->count() }}')

        ->add_column('actions', '<div class="btn-group"><a href="{{{ URL::to(\'admin/slugs/\' . $id . \'/edit\' ) }}}" class="btn btn-primary btn-sm modalfy" >{{{ Lang::get(\'button.edit\') }}}</a>
                <a data-method="delete" data-row="{{{  $id }}}" data-table="blogs"  href="{{{ URL::to(\'admin/slugs/\' . $id . \'\' ) }}}" class="ajax-alert-confirm btn btn-sm btn-danger">{{{ Lang::get(\'button.delete\') }}}</a></div>
            ')

        ->make();
    }

}