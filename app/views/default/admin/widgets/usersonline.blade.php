<li id="widget-usersonline" data-row="2" data-col="1" data-sizex="1" data-sizey="5">
	<div class="panel panel-default">
		<div class="panel-heading clearfix">
			 <span class="panel-title pull-left"><span class="fa fa-lg fa-users"></span> <span class="panel-title-text">{{{ Lang::get('core.users_online') }}}</span></span>
			@include(Theme::path('admin/widget-controls'), array('id' => 'widget-usersonline'))
		</div>
		<div class="panel-body">
			@include(Theme::path('admin/helpers/users-online'))
		</div>
	</div>	
</li>
