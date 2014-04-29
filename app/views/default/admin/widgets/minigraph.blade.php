<li id="widget-minigraphs" data-row="1" data-col="1" data-sizex="2" data-sizey="2" data-max-sizex="2" data-min-sizex="2" data-max-sizey="2"  data-min-sizey="2">
	<div class="container-fluid">
		<div class="row">
			<div class="pull-left col-xs-6  col-sm-3 col-md-3 panel-default-sm">
				<div class="panel panel-default ">
					<div class="panel-body panel-body-full panel-handel">
						<span id="spark_account_created" class="sparklines"  sparkHeight="60" sparkType="bar" sparkBarColor="green"></span>
						<div class="datas-text">{{{ $minigraph_data['account_created']['medium'] }}}  new accounts/week</div>
					</div>
				</div>
			</div>
			<div class="pull-left hidden-xs col-sm-3  col-md-3 panel-default-sm">
				<div class="panel panel-default">
					<div class="panel-body panel-body-full  panel-handel">
						<div id="spark_login" class="sparklines" sparkHeight="60" sparkType="bar" sparkBarColor="orange"></div>
						<div class="datas-text">{{{ $minigraph_data['login']['medium'] }}} logins/week</div>
					</div>
				</div>
			</div>
			<div class="pull-left hidden-xs  col-sm-3 col-md-3 panel-default-sm">
				<div class="panel panel-default">
					<div class="panel-body panel-body-full panel-handel">
						<span id="spark_activity_unique" class="sparklines"  sparkHeight="60" sparkType="bar" sparkBarColor="lightblue"></span>
						<div class="datas-text">{{{ $minigraph_data['activity_unique']['medium'] }}} unique/week</div>
					</div>
				</div>
			</div>
			<div class="pull-left col-xs-6 col-sm-3 col-md-3 panel-default-sm">
				<div class="panel panel-default">
					<div class="panel-body panel-body-full panel-handel">
						<span id="spark_activity" class="sparklines"  sparkHeight="60" sparkType="bar" sparkBarColor="yellow"></span>
						<div class="datas-text">{{{ $minigraph_data['activity']['medium'] }}} hits/week</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</li>
