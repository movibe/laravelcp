<ul class="list-group">
	<li class="list-group-item list-group-item-info">
		<span class="badge">{{ count(DB::select('SELECT id FROM users WHERE UNIX_TIMESTAMP(`last_activity`) > ?', array(time()-150))) }}</span>
		{{{ Lang::get('core.users_online') }}}
	</li>
</ul>