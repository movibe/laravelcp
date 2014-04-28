<div class="form-group">
	<label class="col-md-2 control-label" for="ptitle">{{{ Lang::get('admin/users/profile.Profile_Name') }}}</label>
	<div class="col-md-10">
		<input class="form-control" type="text" name="user_profiles[@if(isset($profile)){{{$profile->id}}}@elsenew@endif][title]" id="ptitle" value="@if(isset($profile)){{{ Input::old('title', isset($user) ? $profile->title : null) }}}@endif" />
	</div>
</div>

<div class="form-group">
	<label class="col-md-2 control-label" for="displayname">{{{ Lang::get('admin/users/profile.Full_Name') }}}</label>
	<div class="col-md-10">
		<input class="form-control" type="text" name="user_profiles[@if(isset($profile)){{{$profile->id}}}@elsenew@endif][displayname]" id="displayname" value="@if(isset($profile)){{{ Input::old('displayname', isset($user) ? $profile->displayname : null) }}}@endif" />
	</div>
</div>

<div class="form-group">
	<label class="col-md-2 control-label" for="address">{{{ Lang::get('admin/users/profile.address') }}}</label>
	<div class="col-md-10">
		<input class="form-control" type="text" name="user_profiles[@if(isset($profile)){{{$profile->id}}}@elsenew@endif][address]" id="address" value="@if(isset($profile)){{{ Input::old('address', isset($user) ? $profile->address : null) }}}@endif" />
	</div>
</div>

<div class="form-group">
	<label class="col-md-2 control-label" for="city">{{{ Lang::get('admin/users/profile.city') }}}</label>
	<div class="col-md-10">
		<input class="form-control" type="text" name="user_profiles[@if(isset($profile)){{{$profile->id}}}@elsenew@endif][city]" id="city" value="@if(isset($profile)){{{ Input::old('city', isset($user) ? $profile->city : null) }}}@endif" />
	</div>
</div>

<div class="form-group">
	<label class="col-md-2 control-label" for="state">{{{ Lang::get('admin/users/profile.state') }}}</label>
	<div class="col-md-10">
		<input class="form-control" type="text" name="user_profiles[@if(isset($profile)){{{$profile->id}}}@elsenew@endif][state]" id="state" value="@if(isset($profile)){{{ Input::old('state', isset($user) ? $profile->state : null) }}}@endif" />
	</div>
</div>

<div class="form-group">
	<label class="col-md-2 control-label" for="zip">{{{ Lang::get('admin/users/profile.zip') }}}</label>
	<div class="col-md-10">
		<input class="form-control" type="text" name="user_profiles[@if(isset($profile)){{{$profile->id}}}@elsenew@endif][zip]" id="zip" value="@if(isset($profile)){{{ Input::old('zip', isset($user) ? $profile->zip : null) }}}@endif" />
	</div>
</div>

<div class="form-group">
	<label class="col-md-2 control-label" for="country">{{{ Lang::get('admin/users/profile.country') }}}</label>
	<div class="col-md-10">
		<input class="form-control" type="text" name="user_profiles[@if(isset($profile)){{{$profile->id}}}@elsenew@endif][country]" id="country" value="@if(isset($profile)){{{ Input::old('country', isset($user) ? $profile->country : null) }}}@endif" />
	</div>
</div>

<div class="form-group">
	<label class="col-md-2 control-label" for="phone">{{{ Lang::get('admin/users/profile.phone') }}}</label>
	<div class="col-md-10">
		<input class="form-control" type="text" name="user_profiles[@if(isset($profile)){{{$profile->id}}}@elsenew@endif][phone]" id="phone" value="@if(isset($profile)){{{ Input::old('phone', isset($user) ? $profile->phone : null) }}}@endif" />
	</div>
</div>

<div class="form-group">
	<label class="col-md-2 control-label" for="mobile">{{{ Lang::get('admin/users/profile.mobile') }}}</label>
	<div class="col-md-10">
		<input class="form-control" type="text" name="user_profiles[@if(isset($profile)){{{$profile->id}}}@elsenew@endif][mobile]" id="mobile" value="@if(isset($profile)){{{ Input::old('mobile', isset($user) ? $profile->mobile : null) }}}@endif" />
	</div>
</div>

<div class="form-group">
	<label class="col-md-2 control-label" for="taxcode">{{{ Lang::get('admin/users/profile.taxcode') }}}</label>
	<div class="col-md-10">
		<input class="form-control" type="text" name="user_profiles[@if(isset($profile)){{{$profile->id}}}@elsenew@endif][taxcode]" id="taxcode" value="@if(isset($profile)){{{ Input::old('taxcode', isset($user) ? $profile->taxcode : null) }}}@endif" />
	</div>
</div>

<div class="form-group">
	<label class="col-md-2 control-label" for="youtube">{{{ Lang::get('admin/users/profile.website') }}}</label>
	<div class="col-md-10">
		<input class="form-control" type="text" name="user_profiles[@if(isset($profile)){{{$profile->id}}}@elsenew@endif][website]" id="website" value="@if(isset($profile)){{{ Input::old('website', isset($user) ? $profile->website : null) }}}@endif" />
	</div>
</div>
<div class="form-group">
	<div class="pull-right">
	@if(isset($profile))
		<a data-method="delete" href="{{{ URL::to('admin/users/' . $user->id . '/profile/'.$profile->id ) }}} " class="ajax-alert-confirm btn btn-danger">Delete {{{ $profile->title }}} </a>
	@endif
	</div>
</div>
