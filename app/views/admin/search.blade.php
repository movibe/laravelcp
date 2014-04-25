
<br/>
@foreach($results as $index=>$data)
<div class="panel panel-default">
	<div class="panel-heading" style="text-transform: uppercase">{{{ $index }}}</div>
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
						<td>{{{ substr($val,0,40)}}}</td>
					@endforeach
				</tr>
			@endforeach
		</table>
	</div>
</div>
@endforeach
		