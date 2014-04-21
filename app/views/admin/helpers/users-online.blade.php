<ul class="list-group">
	@foreach (DB::select('SELECT email, displayname, id FROM users WHERE last_activity > ? LIMIT 50', array(time()-600)) as $row)
		<li class="list-group-item">
			<a href="{{{ URL::to('admin/users/'. $row->id  .'/edit') }}}" class="modalfy">
				<h4 class="list-group-item-heading">{{{ $row->displayname }}}</h4>
				<p class="list-group-item-text">
					<span class="glyphicon"><img alt="{{{ $row->email }}}" src="{{ Gravatar::src($row->email, 40) }}"></span>  
					{{{ $row->email }}}
				</p>
			</a>
		</li>
	@endforeach
</ul>