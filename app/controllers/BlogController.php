<?php

class BlogController extends BaseController {

    /**
     * Post Model
     * @var Post
     */
    protected $post;

    /**
     * User Model
     * @var User
     */
    protected $user;

    /**
     * Inject the models.
     * @param Post $post
     * @param User $user
     */
    public function __construct(Post $post, User $user)
    {
        parent::__construct();

        $this->post = $post;
        $this->user = $user;
    }
    

	public function getJavascript(){

		$contents = View::make('translations');
		$response = Response::make($contents);
		$response->header('Content-Type', 'application/javascript');
		return $response;

	}


	/**
	 * Returns all the blog posts.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		$home = $this->post->where('slug', '=', 'home')->first();
		if(count($home) == 1){
			return Theme::make('site/blog/home', compact('home'));

		} else {
			$posts = $this->post->orderBy('created_at', 'DESC')->paginate(10);
			return Theme::make('site/blog/index', compact('posts'));
		}
	}

	/**
	 * View a blog post.
	 *
	 * @param  string  $slug
	 * @return View
	 * @throws NotFoundHttpException
	 */
	public function getView($slug)
	{
		// Get this blog post data
		$post = $this->post->where('slug', '=', $slug)->first();

		// Check if the blog post exists
		if (is_null($post))
		{
			// If we ended up in here, it means that
			// a page or a blog post didn't exist.
			// So, this means that it is time for
			// 404 error page.
			return App::abort(404);
		}

		// Get this post comments
		$comments = $post->comments()->orderBy('created_at', 'ASC')->get();

        // Get current user and check permission
        $user = $this->user->currentUser();
        $canComment = false;
        if(!empty($user)) {
            $canComment = $user->can('post_comment');
        }

		// Show the page
		return Theme::make('site/blog/view_post', compact('post', 'comments', 'canComment'));
	}

	/**
	 * View a blog post.
	 *
	 * @param  string  $slug
	 * @return Redirect
	 */
	public function postView($slug)
	{

        $user = $this->user->currentUser();
        $canComment = $user->can('post_comment');
		if ( ! $canComment)
		{
			return Redirect::to($slug . '#comments')->with('error',  Lang::get('site.login_to_post'));
		}

		// Get this blog post data
		$post = $this->post->where('slug', '=', $slug)->first();

		// Declare the rules for the form validation
		$rules = array(
			'comment' => 'required|min:3',
			'comment_hp'   => 'honeypot',
			'comment_time'   => 'required|honeytime:5'
		);

		// Validate the inputs
		$validator = Validator::make(Input::all(), $rules);

		// Check if the form validates with success
		if ($validator->passes())
		{
			// Save the comment
			$comment = new Comment;
			$comment->user_id = Auth::user()->id;
			$comment->content = Input::get('comment');

			// Was the comment saved with success?
			if($post->comments()->save($comment))
			{
				// Redirect to this blog post page
				return Redirect::to($slug . '#comments')->with('success',  Lang::get('site.comment_added'));
			}

			// Redirect to this blog post page
			return Redirect::to($slug . '#comments')->with('error',  Lang::get('site.comment_not_Added'));
		}

		// Redirect to this blog post page
		return Redirect::to($slug)->withInput()->withErrors($validator);
	}

	public function postContactUs(){

			$rules = array(
				'email'     => "required|email",
				'conact_us'   => 'honeypot',
				'contact_us_time'   => 'required|honeytime:5'
			);
			 
			$validator = Validator::make(Input::get(), $rules);

			if ($validator->passes())
			{
				try{
					$body='From:'. Input::get('name'). ' ('. Input::get('email') .')<br/><br/>'.Input::get('body');

					$send=Mail::send('emails/default', array('body'=>$body), function($message)
					{
						$message->to(Setting::get('site.contact_email'))->subject(Input::get('subject'));
						$message->replyTo(Input::get('email', Input::get('name')));

					});
				} catch (Exception $e) {
				 return Redirect::to('contact-us')->with( 'error', Lang::get('core.email_not_sent') );
				}
			} else return Redirect::to('contact-us')->withInput()->with( 'error', Lang::get('core.email_not_sent') );

        return Redirect::to('contact-us')->with( 'success', Lang::get('core.email_sent') );

	}

	public function getContactUs(){
		return Theme::make('site/contact-us');
	}

}
