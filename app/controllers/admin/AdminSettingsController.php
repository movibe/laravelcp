<?php

class AdminSettingsController extends AdminController
{

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Show a list of all the comment posts.
     *
     * @return View
     */
    public function getIndex()
    {

		View::share('settings',  Setting::all());

        // Title
        $title = Lang::get('admin/settings/title.title');

        // Show the page
        return Theme::make('admin/settings/index', compact('comments', 'title'));
    }

   

    /**
     * Update the specified resource in storage.
     *
     * @param $comment
     * @return Response
     */
	public function postIndex()
	{

        $rules = array(
        );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        // Check if the form validates with success
        if ($validator->passes())
        {

			$settings = Input::get('settings');
			if(isset($settings) && is_array($settings))
			{
				foreach($settings as $var => $val) Setting::set($var, $val);
				Setting::save();
			}

			
			
			// Redirect to the comments post management page
            return Redirect::to('admin/settings')->with('success', Lang::get('admin/settings/messages.update.success'));
        }

        // Form validation failed
        return Redirect::to('admin/settings')->withInput()->withErrors($validator);

	}


}
