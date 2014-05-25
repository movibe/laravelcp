<ul class="list-group list-users-online">
	@foreach (Dashboard::online($value) as $row)
		<li class="list-group-item">
			<a href="{{{ URL::to('admin/users/'. $row->id  .'/edit') }}}" class="modalfy">
				<h4 class="list-group-item-heading">{{{ $row->displayname }}}<span class="pull-right">{{{ Lang::get('core.lastactivity') }}}</span></h4>
				<span class="pull-right"> {{{ Carbon::parse($row->last_activity)->diffForHumans() }}}</span>
				<p class="list-group-item-text">
					<span class="glyphicon"><img alt="{{{ $row->email }}}" src="{{ Gravatar::src($row->email, 40) }}"></span>  
					<span class="hidden-sm">{{{ $row->email }}}</span>
				</p>
			</a>
		</li>
	@endforeach
</ul>