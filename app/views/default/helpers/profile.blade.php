{{ Form::input_group('text', 'user_profiles['. ( isset($profile) ? $profile->id : 'new' ).'][title]', 
	Lang::get('admin/users/profile.Profile_Name'), isset($profile) ? $profile->title : null, $errors, array('maxlength'=>'70')) }} 

{{ Form::input_group('text', 'user_profiles['. ( isset($profile) ? $profile->id : 'new' ).'][displayname]', 
	Lang::get('admin/users/profile.Full_Name'), isset($profile) ? $profile->displayname : null, $errors, array('maxlength'=>'70')) }} 

{{ Form::input_group('text', 'user_profiles['. ( isset($profile) ? $profile->id : 'new' ).'][address]', 
	Lang::get('admin/users/profile.address'), isset($profile) ? $profile->address : null, $errors, array('maxlength'=>'254')) }} 

{{ Form::input_group('text', 'user_profiles['. ( isset($profile) ? $profile->id : 'new' ).'][city]', 
	Lang::get('admin/users/profile.city'), isset($profile) ? $profile->city : null, $errors, array('maxlength'=>'254')) }} 

{{ Form::input_group('text', 'user_profiles['. ( isset($profile) ? $profile->id : 'new' ).'][state]', 
	Lang::get('admin/users/profile.state'), isset($profile) ? $profile->state : null, $errors, array('maxlength'=>'254')) }} 

{{ Form::input_group('text', 'user_profiles['. ( isset($profile) ? $profile->id : 'new' ).'][zip]', 
	Lang::get('admin/users/profile.zip'), isset($profile) ? $profile->zip : null, $errors, array('maxlength'=>'254')) }} 

{{ Form::input_group('text', 'user_profiles['. ( isset($profile) ? $profile->id : 'new' ).'][country]', 
	Lang::get('admin/users/profile.country'), isset($profile) ? $profile->country : null, $errors, array('maxlength'=>'254')) }} 

{{ Form::input_group('text', 'user_profiles['. ( isset($profile) ? $profile->id : 'new' ).'][phone]', 
	Lang::get('admin/users/profile.phone'), isset($profile) ? $profile->phone : null, $errors, array('maxlength'=>'70')) }} 

{{ Form::input_group('text', 'user_profiles['. ( isset($profile) ? $profile->id : 'new' ).'][mobile]', 
	Lang::get('admin/users/profile.mobile'), isset($profile) ? $profile->mobile : null, $errors, array('maxlength'=>'70')) }} 

{{ Form::input_group('text', 'user_profiles['. ( isset($profile) ? $profile->id : 'new' ).'][taxcode]', 
	Lang::get('admin/users/profile.taxcode'), isset($profile) ? $profile->taxcode : null, $errors, array('maxlength'=>'70')) }} 

{{ Form::input_group('text', 'user_profiles['. ( isset($profile) ? $profile->id : 'new' ).'][website]', 
	Lang::get('admin/users/profile.website'), isset($profile) ? $profile->website : null, $errors, array('maxlength'=>'254')) }} 
