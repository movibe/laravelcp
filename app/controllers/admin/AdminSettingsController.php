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
		$settings=Setting::all();
        $title = Lang::get('admin/settings/title.title');
        return Theme::make('admin/settings/index', compact('comments', 'title', 'settings'));
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

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes())
        {

			$settings = Input::get('settings');
			if(isset($settings) && is_array($settings))
			{
				foreach($settings as $var => $val) Setting::set($var, $val);
				Setting::save();
			}

            return Api::to(array('success', Lang::get('admin/settings/messages.update.success'))) ? : Redirect::to('admin/settings')->with('success', Lang::get('admin/settings/messages.update.success'));
        } else return Api::to(array('error', Lang::get('admin/settings/messages.update.error'))) ? : Redirect::to('admin/settings')->withInput()->withErrors($validator);
	}
}