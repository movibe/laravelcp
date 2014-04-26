<ul class="list-group list-users-online">
	@foreach (DB::select('SELECT email, displayname, id, last_activity FROM users WHERE UNIX_TIMESTAMP(`last_activity`) > ? LIMIT 50', array(time()-150)) as $row)
		<li class="list-group-item">
			<a href="{{{ URL::to('admin/users/'. $row->id  .'/edit') }}}" class="modalfy">
				<h4 class="list-group-item-heading">{{{ $row->displayname }}}</h4>
				<span class="pull-right">{{{ Carbon::parse($row->last_activity)->diffForHumans() }}}</span>
				<p class="list-group-item-text">
					<span class="glyphicon"><img alt="{{{ $row->email }}}" src="{{ Gravatar::src($row->email, 40) }}"></span>  
					<span class="hidden-sm">{{{ $row->email }}}</span>
				</p>
			</a>
		</li>
	@endforeach
</ul>