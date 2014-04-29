<li id="widget-graph" data-row="3" data-col="1" data-sizex="2" data-sizey="5">
	<div class="panel panel-default">
	  <div class="panel-heading clearfix">
		  <span class="panel-title pull-left"><span class="fa fa-lg fa-signal"></span>  <span class="panel-title-text">User Activity</span></span>
		  @include(Theme::path('admin/widget-controls'), array('id' => 'widget-graph'))
	  </div>
	  <div class="panel-body" style="overflow: hidden">
			{{ Lava::LineChart('Stocks')->outputInto('stocks_div') }}
			{{ Lava::div('80%', '') }}
		</div>
	</div>			
</li>
