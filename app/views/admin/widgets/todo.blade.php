<li id="widget-todo" data-row="4" data-col="1" data-sizex="1" data-sizey="5">
	<div class="panel panel-default">
	  <div class="panel-heading clearfix">
		  <span class="panel-title pull-left"><span class="fa fa-lg fa-asterisk"></span> <span class="panel-title-text">To-do</span></span>
		  @include('admin/widget-controls', array('id' => 'widget-todo'))
			<ul class="nav nav-tabs pull-right hidden-xs  hidden-sm">
			  <li class="active"><a href="#home" data-toggle="tab">Pending</a></li>
			  <li><a href="#profile" data-toggle="tab">Completed</a></li>
			</ul>
	  </div>
	  <div class="panel-body ">
		<div class="tab-content">
			<div class="tab-pane active" id="home">
				<ul class="list-group">
					<li class="list-group-item">work on a user interface, profile editor, pages etc - bootsnip for ideas</li>
					<li class="list-group-item">add notify when user is gonna be cancelled, add option to cancel cancellation</li>
				</ul>
			</div>
			<div class="tab-pane" id="profile">...</div>
		</div>
	  </div>
	</div>			
</li>
