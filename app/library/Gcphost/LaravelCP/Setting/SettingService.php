<?php 

class SettingService {
	public function index()
    {
		$settings=Setting::all();
        return Theme::make('admin/settings/index', compact('comments', 'settings'));
    }
   
	public function post()
	{

		$settings = Input::get('settings');
		if(isset($settings) && is_array($settings))
		{
			foreach($settings as $var => $val) Setting::set($var, $val);
			Setting::save();
		}

		return Api::to(array('success', Lang::get('admin/settings/messages.update.success'))) ? : Redirect::to('admin/settings')->with('success', Lang::get('admin/settings/messages.update.success'));
	}
}