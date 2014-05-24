@extends(Theme::path('site/layouts/default'))
@section('title')
	{{{ Lang::get('site.contact_us') }}} ::
@parent
@stop

@section('content')

<div class="page-header">
	<h3>{{{ Lang::get('site.contact_us') }}}</h3>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="well well-sm">
				{{ Form::open_horizontal() }}
				{{ Form::honeypot('contact_us', 'contact_us_time') }}
                <div class="row">
                    <div class="col-md-6">

						{{ Form::input_group('text', 'name', '', '', $errors, array('maxlength'=>'70','required'=>'required', 'placeholder'=>Lang::get('site.your_name')), '', false, 'fa fa-fw fa-user') }} 

						
						{{ Form::input_group('email', 'email', '', '', $errors, array('required'=>'required', 'placeholder'=>Lang::get('site.your_email')), '', false, 'fa fa-fw fa-envelope') }} 
						
						{{ Form::select_group('subject', '',
								array(
									Lang::get('site.email_option1') => Lang::get('site.email_option1'),
									Lang::get('site.email_option2') => Lang::get('site.email_option2'),
									Lang::get('site.email_option3') => Lang::get('site.email_option3'),
									),
									'', $errors,'', '',false) }} 	

                    </div>
                    <div class="col-md-6">

						{{ Form::textarea_group('body', '', '', $errors, array('placeholder' => Lang::get('site.message'), 'size'=>'25x9','required'=>'required'), '', false) }} 

                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary pull-right">{{{ Lang::get('site.send_message') }}}</button>
                    </div>
                </div>
				{{ Form::close() }}
            </div>
        </div>
        <div class="col-md-4">
            <legend><span class="fa fa-globe"></span> {{{ Lang::get('site.our_location') }}}</legend>
            <address>
                {{ Setting::get('site.contact_address') }}
            </address>
            <address>
                <a href="mailto:#">{{{ Setting::get('site.contact_email') }}}</a>
            </address>
        </div>
    </div>
</div>
@stop