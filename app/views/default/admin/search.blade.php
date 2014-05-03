<div class="panel-group" id="accordion">
@foreach($results as $index=>$data)
<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="panel-title">
			<a data-toggle="collapse" data-parent="#accordion" href="#accord-{{{ $index }}}" style="text-transform: uppercase">
				{{{ str_replace('_',' ',$index) }}}
			</a>
		</h4>
	</div>
	<div id="accord-{{{ $index }}}" class="panel-collapse collapse">
		<div class="panel-body">
			<table class="table">
				<thead>
					@foreach($data as $column => $value)
						@foreach($value as $key => $val)
							<th>{{{ str_replace('_',' ',$key) }}}</th>
						@endforeach
						{{ ''; break }}
					@endforeach
				</thead>
				@foreach($data as $column => $value)
					<tr>
						@foreach($value as $key => $val)
							<td>
								@if ($action =  Search::GetAction($index, $key)) @endif
								@if($action['method'])
									@if($action['method'] == "modal")
										<a href="{{ URL::to(str_replace('?', $val, $action['action'])) }}" class="modalfy">{{{ Str::limit(strip_tags($val), 42, "...") }}}</a>
									@elseif($action['method'] == "link")
										<a href="{{ URL::to(str_replace('?', $val, $action['action'])) }}">{{{ Str::limit(strip_tags($val), 42, "...") }}}</a>
									@endif
								@else
									{{{ Str::limit(strip_tags($val), 42, "...") }}} 
								@endif
							</td>
						@endforeach
					</tr>
				@endforeach
			</table>
		</div>
	</div>
</div>
@endforeach
</div>		
@foreach($results as $index=>$data)
<script type="text/javascript">
	$('#accord-{{ $index }}').collapse('show');
</script>
{{ ''; break }}
@endforeach
