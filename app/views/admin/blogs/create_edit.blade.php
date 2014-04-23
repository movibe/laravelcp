@extends('admin.layouts.modal')

@section('content')
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-general" data-toggle="tab">{{{ Lang::get('core.general') }}}</a></li>
		<li><a href="#tab-meta-data" data-toggle="tab">{{{ Lang::get('admin/slugs.meta_data') }}}</a></li>
		<li><a href="#tab-settings" data-toggle="tab">{{{ Lang::get('core.settings') }}}</a></li>
	</ul>

	@if ($message = Session::get('success'))
	<script type="text/javascript">
		if(parent.$('#blogs').html()){
			var oTable = parent.$('#blogs').dataTable();
			oTable.fnReloadAjax();
		}
	</script>
	@endif

	@if (isset($post))
		{{ Form::open(array('url' => URL::to('admin/slugs/' . $post->id . '/edit'), 'class' => 'form-horizontal form-ajax', 'onsubmit' => "$('#wysiwyg-body').html($('#editor').html())")) }}
	@else
		{{ Form::open(array('class' => 'form-horizontal form-ajax', 'onsubmit' => "$('#wysiwyg-body').html($('#editor').html())")) }}
	@endif

		<div class="tab-content">
			<div class="tab-pane active" id="tab-general">

				<div class="form-group {{{ $errors->has('title') ? 'error' : '' }}}">
                    <div class="col-md-12">
						<input placeholder="{{{ Lang::get('admin/slugs.post_title') }}}" class="form-control" type="text" name="title" id="title" value="{{{ Input::old('title', isset($post) ? $post->title : null) }}}" />
						{{ $errors->first('title', '<span class="help-inline">:message</span>') }}
					</div>
				</div>

				<div class="form-group {{{ $errors->has('content') ? 'error' : '' }}}">
					<div class="col-md-12">
						@section('wysiywg-content')
							{{ Input::old('content', isset($post) ? $post->content : null) }}
						@stop
						<p>@include('wysiwyg')</p>

						<textarea id="wysiwyg-body" class="hide" name="content" value="content" rows="10"></textarea>
						{{ $errors->first('content', '<span class="help-inline">:message</span>') }}
					</div>
				</div>

			</div>

			<div class="tab-pane" id="tab-meta-data">
				<div class="form-group {{{ $errors->has('meta-title') ? 'error' : '' }}}">
					<div class="col-md-12">
                        <label class="control-label" for="meta-title">{{{ Lang::get('admin/slugs.meta_title') }}}</label>
						<input class="form-control" type="text" name="meta-title" id="meta-title" value="{{{ Input::old('meta-title', isset($post) ? $post->meta_title : null) }}}" />
						{{ $errors->first('meta-title', '<span class="help-inline">:message</span>') }}
					</div>
				</div>

				<div class="form-group {{{ $errors->has('meta-description') ? 'error' : '' }}}">
					<div class="col-md-12 controls">
                        <label class="control-label" for="meta-description">{{{ Lang::get('admin/slugs.meta_description') }}}</label>
						<input class="form-control" type="text" name="meta-description" id="meta-description" value="{{{ Input::old('meta-description', isset($post) ? $post->meta_description : null) }}}" />
						{{{ $errors->first('meta-description', '<span class="help-inline">:message</span>') }}}
					</div>
				</div>

				<div class="form-group {{{ $errors->has('meta-keywords') ? 'error' : '' }}}">
					<div class="col-md-12">
                        <label class="control-label" for="meta-keywords">{{{ Lang::get('admin/slugs.meta_keywords') }}}</label>
						<input class="form-control" type="text" name="meta-keywords" id="meta-keywords" value="{{{ Input::old('meta-keywords', isset($post) ? $post->meta_keywords : null) }}}" />
						{{ $errors->first('meta-keywords', '<span class="help-inline">:message</span>') }}
					</div>
				</div>

			</div>

			<div class="tab-pane" id="tab-settings">
				<div class="form-group {{{ $errors->has('banner') ? 'error' : '' }}}">
					<div class="col-md-12">
                        <label class="control-label" for="banner">{{{ Lang::get('admin/slugs.banner') }}}</label>
						<input class="form-control" type="text" name="banner" id="banner" value="{{{ Input::old('banner', isset($post) ? $post->banner : null) }}}" />
						{{ $errors->first('banner', '<span class="help-inline">:message</span>') }}
					</div>
				</div>
				<div class="form-group {{{ $errors->has('banner') ? 'error' : '' }}}">
					<div class="col-md-12">
                        <label class="control-label" for="template">{{{ Lang::get('core.template') }}}</label>
						<input class="form-control" type="text" name="template" id="template" value="{{{ Input::old('template', isset($post) ? $post->template : null) }}}" />
						{{ $errors->first('template', '<span class="help-inline">:message</span>') }}
					</div>
				</div>

				<div class="form-group {{{ $errors->has('banner') ? 'error' : '' }}}">
					<div class="col-md-12">
                        <label class="control-label" for="parent">{{{ Lang::get('core.parent') }}}</label>
						<input class="form-control" type="text" name="parent" id="parent" value="{{{ Input::old('parent', isset($post) ? $post->parent : null) }}}" />
						{{ $errors->first('parent', '<span class="help-inline">:message</span>') }}
					</div>
				</div>

				<div class="form-group {{{ $errors->has('display_navigation') ? 'error' : '' }}}">
					<div class="col-md-12">
                        <label class="control-label" for="display_navigation">{{{ Lang::get('core.display_navigation') }}}</label>
						<input class="form-control" type="text" name="display_navigation" id="pardisplay_navigationent" value="{{{ Input::old('display_navigation', isset($post) ? $post->display_navigation : null) }}}" />
						{{ $errors->first('display_navigation', '<span class="help-inline">:message</span>') }}
					</div>
				</div>

				<div class="form-group {{{ $errors->has('meta-description') ? 'error' : '' }}}">
					<div class="col-md-12 controls">
						Display Author: <input value="1" type="checkbox" name="display_author" class="form-control" >
						Allow Comments: <input value="1" type="checkbox" name="allow_comments" class="form-control" >
					</div>
				</div>

			</div>
		</div>

		<div class="modal-footer">
			{{ Form::reset(Lang::get('button.cancel'), array('class' => 'btn btn-danger', 'onclick'=>"$('#site-modal').modal('hide')")); }} 
			{{ Form::reset(Lang::get('button.reset'), array('class' => 'btn btn-default')); }} 
			{{ Form::submit(Lang::get('button.save'), array('class' => 'btn btn-success')); }} 
		</div>
	{{ Form::close(); }}
@stop
@section('styles')
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
	<style type="text/css"> 
		#editor {
			height: 200px;
			overflow: auto;
		}
	</style>
@stop
@section('scripts')
	<script src="//cdn.jsdelivr.net/bootstrap.wysiwyg/0.1/bootstrap-wysiwyg.min.js"></script>
	<script src="{{{ asset('assets/js/bootstrap-wysiwyg-start.js') }}}"></script>
@stop