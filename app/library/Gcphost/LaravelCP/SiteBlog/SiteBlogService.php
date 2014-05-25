<?php 
use Gcphost\LaravelCP\Blog\BlogRepository as Post;

class SiteBlog {
    protected $post;
    protected $user;

    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }
    
	public function index()
	{
		$home = $this->post->where('slug', '=', 'home')->first();
		if(count($home) == 1){
			return Theme::make('site/blog/home', compact('home'));
		} else {
			$posts = $this->post->orderBy('created_at', 'DESC')->paginate(10);
			return Theme::make('site/blog/index', compact('posts'));
		}
	}

	public function view($slug)
	{
		$post = $this->post->where('slug', '=', $slug)->first();

		if(is_null($post)) return App::abort(404);
		
		$comments = $post->getcomments();

        $user = $this->user->currentUser();
        $canComment = false;
        if(!empty($user)) $canComment = $user->can('post_comment');
        
		return Theme::make('site/blog/view_post', compact('post', 'comments', 'canComment'));
	}

	public function post($slug)
	{
        $user = $this->user->currentUser();
        $canComment = $user->can('post_comment');
		if(!$canComment) return Redirect::to($slug . '#comments')->with('error',  Lang::get('site.login_to_post'));
		
		$post = $this->post->getpost($slug);

		$rules = array(
			'comment' => 'required|min:3',
			'comment_hp'   => 'honeypot',
			'comment_time'   => 'required|honeytime:5'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->passes())
		{
			return $post->comment() ?
				Redirect::to($slug . '#comments')->with('success',  Lang::get('site.comment_added')) :
				Redirect::to($slug . '#comments')->with('error',  Lang::get('site.comment_not_Added'));
		} else return Redirect::to($slug)->withInput()->withErrors($validator);
	}

	public function postContactUs(){
			$rules = array(
				'email'     => "required|email|max:254",
				'conact_us'   => 'honeypot',
				'contact_us_time'   => 'required|honeytime:5'
			);
			 
			$validator = Validator::make(Input::get(), $rules);

			if ($validator->passes())
			{
				if(!LaravelCP::sendEmailContactUs())
					return Redirect::to('contact-us')->with( 'error', Lang::get('core.email_not_sent') );
			} else return Redirect::to('contact-us')->withInput()->with( 'error', Lang::get('core.email_not_sent') );
        return Redirect::to('contact-us')->with( 'success', Lang::get('core.email_sent') );

	}

	public function getContactUs(){
		return Theme::make('site/contact-us');
	}
}