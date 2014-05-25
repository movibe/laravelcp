 <!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>
			@section('title')
				{{{ Setting::get('site.name') }}}
			@show
		</title>
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<meta name="description" content="" />
		<meta name="csrf-token" content="{{{ csrf_token() }}}"/>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="{{{ asset('assets/bootswatch/'. Setting::get('site.bootswatch') .'/bootstrap.min.css') }}}" rel="stylesheet">
		<link href="{{{ asset('assets/css/font-awesome.min.css') }}}" rel="stylesheet">
		<style type="text/css">
			#logo{background:url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAMAAAHMJ3jJAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyBpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEzNDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNSBXaW5kb3dzIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOjM4M0QzMzg1RDg1ODExRTM5RkM1QjJCRUI2MjgzMjRFIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOjM4M0QzMzg2RDg1ODExRTM5RkM1QjJCRUI2MjgzMjRFIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6MzgzRDMzODNEODU4MTFFMzlGQzVCMkJFQjYyODMyNEUiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6MzgzRDMzODREODU4MTFFMzlGQzVCMkJFQjYyODMyNEUiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz4YBCo7AAADAFBMVEX7aVf6Tjf6SjP6Mhn6Tzn7ZFD6SDH6UDv6TDb6TTf6Ri/6Tjj6SzT/9/b6STL6RC3/+vn6Uz37alf6Tzj//f37ZlP6SjT6Ri76RCz//v77V0L6RS36SzX6QSn6Qyz6VT/6UDn/+Pf8mo76RS7//Pz7eGj/8/L+3Nf6Qiv6W0f8o5f7gXH9r6b7bFn6Ujz7emn9vrb7gHD8jYD9r6X7dGP9uK/+5uP7dWT9xr/9tq39sKf8hnb6TDX7Y1D/8/H6Ry/+4t7/6+n7ZFH+7Or9vLP6QCn6RzD6RzH/8fD+5OD7fm77dmT6TTb7Z1T8mo36WkX8g3T9xLz/+fj6PSX7bVr6Xkr8jH7+z8r8iHn7bFr/9PP7bl3/+/v8mIv/5eL5Mhn9rqT8dGP+4t/8hnf9raP7VkH6YU36Qin8raL6WUP8iHj6VD77VT/9yMH8koT9xL39rqP/8e/7g3T9mIz/9fT+29X6V0P7b137alj9sKb6VkH/7+z7XUn9ysT9qZ78nZH8joH8jHz7c2H+4d3+3Nj+3dr9xLv+3tr6Nh36WUT+zMb//fz9oZX9oZb+8/L8iXv6QCf7lIf+ycT9wLj+wrv8hHX8hHb+5+T6Pyj6STP7a1n+8vD8i3z+v7f/4+D7iHr8lYj9o5j7eGb+5OH9x8D+x8D+x8L8rKL9rKL7e2v9q6H7cF77Uz3+0cv//Pv+49/6TTj8gnL+8O7/8O79tKv7blv9xb36SDL9xr77ZVL7STL8p536VD//8vD+ycP9l4r+6ef+1tH8gHD9sqj+3tn///79s6r6QCj8inv+zsb7eWj7eWn6OB76STH7dGL7dWP6RjD/+vr/9vT/9/X8eGj8emn/5uP8h3j6Pif8h3r7fW3+zcf6UTr7blz+2NP9urL9u7P6Ri37a1j+tq39qqD8pZr8ppv6VkD+8fD8moz/7+36XEj+0s37emr+z8n6PCT+19P7eWf9y8T6RS/7Yk39qZ/7X0r7WkX8nZD8kYT8joD6UTv7ZVH////6UDr////9EYT2AAABAHRSTlP///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////8AU/cHJQAAAxtJREFUeNpi+P8HCBj+/Nv09x/DHxbBJ+xAdmUZkP2P/d8/gABi0AdKrmL4x2727x/Dv3v/gGr+sf8Fsf+x/fsHEEAM1v9gAKj839+/Tn8dYMzff9dDmP+yLdhACv7D1QIEEMN/1j8Q8J/hH0IUiMPOnuGBMKXzlE4ai4GZU/7+Y3nzDcyUmC/r1MMDUfsbaAdU27/aXJgJ//h84EwIAAggJIvh4BQDK4QhzMY9UVgayQ9Aoa1cfgIiDte5/H8jBJmY//76/Ztr+n1XFoQgT7xA7+9/bpcXzkASZNG9IZklG9fG1omkHeRc64CNHCgWAYFESYwVN0xQCNOdwFA7hyH2HyCAGP7/3/kHGbCq/v/P4PUPi0o4kx3OMoQK/hb/Z+gvA3USK1SQX6Rm7S2DyWD//PsDERQWNO+SlNwtr8uBEGRZMe+S4yztv4//SiEEfz80/xv8W+/73w42hCD/X61Wzn//5P4+VeGDC7JL2/49/u83w19mJJUKGaUXi//ZvzqMbOY/bvmwo++r/nIJIdkOBBp///51tGH/hyLIvShg6msoGy7IoWOxpOk3muC/KyoiXOgq/7Gwsf3GEEQCvtgE/2NJYKv/AwQYMI5U/xEE//9j041dKcMjVIHfQKdyaXD8/vcb3ZF/kLksHFdN+NN4/76cEBqRyYEs8wdJ4R0Wd9dp665F2y7Q+vjcVMDF3k3mNzaFv5WN+t5x93v8/curBowBg11Ks/M5ObGZ6JMTq33w74GKYHF3WbG5fwUa/UJmsmMqVNh+89PP/X+dNXnA9vFb/n2TGFiwhhNTIV/yvgajv7wM4ChiYdrxd1L50hQ9TnZMq23klU5v+7tYig+oMl3n79639Xf5sHsmzC5wQ/jf9j0y/ySW/w0SmvNiCicjNs/8Flb24RRM+ns7UujH3+5Dcv/EebAGD0Sx3IkgXkVFXsVlYiz/cAU4JGkKuhxRV2/5cP7Cb/wK/7FpfrVKOLbyM/s/AgpZ/n0RFRVN5f6HrpAVI0X9/v37N4YgK0MRcenRi+G/PjHqvIEpHAhMWFn/4ASsrE0gNQDtiiIv4UoUuwAAAABJRU5ErkJggg==");float:left;width:40px;height:40px;margin-top:5px;margin-right:8px;margin-left:5px}
			body{ padding-top: 60px}
		@yield('styles')
		</style>

   <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->


		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{{ asset('assets/ico/apple-touch-icon-144-precomposed.png') }}}">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{{ asset('assets/ico/apple-touch-icon-114-precomposed.png') }}}">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{{ asset('assets/ico/apple-touch-icon-72-precomposed.png') }}}">
		<link rel="apple-touch-icon-precomposed" href="{{{ asset('assets/ico/apple-touch-icon-57-precomposed.png') }}}">
		<link rel="shortcut icon" href="{{{ asset('assets/ico/favicon.png') }}}">
	</head>

	<body>
		<div id="wrap">
			<div class="navbar navbar-default  navbar-fixed-top">
				 <div class="container">
					<div class="navbar-header">
						<div id="logo"></div>
						<a href="{{{ URL::to('/') }}}" class="navbar-brand">{{{ Setting::get('site.name') }}}</a>
						<button type="button" class="fa fa-lg fa-bars hidden-sm hidden-md hidden-lg navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
							<span class="sr-only">{{{ Lang::get('core.toggle_nav') }}}</span>
						</button>
					</div>
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav">
							<li {{ (Request::is('contact-us') ? ' class="active"' : '') }}><a href="{{{ URL::to('contact-us') }}}">{{{ Lang::get('site.contactus') }}}</a></li>
							@foreach (DB::select('SELECT title, slug FROM posts WHERE parent = 0 AND display_navigation = 1') as $row)
								<li {{ (Request::is($row->slug) ? ' class="active"' : '') }}>
									<a href="{{{ URL::to($row->slug) }}}">
											{{{ $row->title }}}
									</a>
								</li>
							@endforeach
						</ul>

						<ul class="nav navbar-nav pull-right">
							@if (Auth::check())
								@if (Auth::user()->hasRole('admin'))
								<li class="dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" href="#">
										{{{ Auth::user()->email }}}	<span class="caret"></span>
									</a>
									<ul class="dropdown-menu">
										<li><a href="{{{ URL::to('admin') }}}"><span class="fa fa-cog fa-fw"></span>  &nbsp; {{{ Lang::get('site.admin_panel') }}}</a></li>
										<li class="divider"></li>
										<li><a href="{{{ URL::to('user') }}}"><span class="fa fa-wrench fa-fw"></span>  &nbsp; {{{ Lang::get('core.profile') }}}</a></li>
										<li class="divider"></li>
										<li><a href="{{{ URL::to('user/logout') }}}"><span class="fa fa-sign-out fa-fw"></span>  &nbsp; {{{ Lang::get('core.logout') }}}</a></li>
									</ul>
								</li>
								@else
									<li class="dropdown">
										<a class="dropdown-toggle" data-toggle="dropdown" href="#">
											{{{ Auth::user()->email }}}	<span class="caret"></span>
										</a>
										<ul class="dropdown-menu">
											<li><a href="{{{ URL::to('user') }}}"><span class="fa fa-wrench fa-fw"></span>  &nbsp; {{{ Lang::get('core.profile') }}}</a></li>
											<li class="divider"></li>
											<li><a href="{{{ URL::to('user/logout') }}}"><span class="fa fa-sign-out fa-fw"></span>  &nbsp; {{{ Lang::get('core.logout') }}}</a></li>
										</ul>
									</li>
								@endif
							@else
								<li {{ (Request::is('user/login') ? ' class="active"' : '') }}><a href="{{{ URL::to('user/login') }}}">{{{ Lang::get('user/user.login') }}}</a></li>
								<li {{ (Request::is('user/create') ? ' class="active"' : '') }}><a href="{{{ URL::to('user/create') }}}">{{{ Lang::get('site.sign_up') }}}</a></li>
							@endif
						</ul>
					</div>
				</div>
			</div>

			<div class="container">
				@include(Theme::path('notifications'))

				@yield('content')
				<hr/>
			</div>

		<div id="push"></div>
		</div>


	    <div id="footer">
	      <div class="container">
	        <p class="muted credit">&copy; {{ date('Y') }} {{{ Setting::get('site.name') }}}</p>
	      </div>
	    </div>

	<script src="{{{ asset('assets/js/jquery.min.js') }}}"></script>
	<script src="{{{ asset('assets/js/bootstrap.min.js') }}}"></script>
	<script type="text/javascript">
		$.ajaxSetup({data:{csrf_token:$('meta[name="csrf-token"]').attr("content")}});

		/* http://bootboxjs.com/license.txt */
		!function(a,b){"use strict";"function"==typeof define&&define.amd?define(["jquery"],b):"object"==typeof exports?module.exports=b(require("jquery")):a.bootbox=b(a.jQuery)}(this,function a(b,c){"use strict";function d(a){var b=q[o.locale];return b?b[a]:q.en[a]}function e(a,c,d){a.stopPropagation(),a.preventDefault();var e=b.isFunction(d)&&d(a)===!1;e||c.modal("hide")}function f(a){var b,c=0;for(b in a)c++;return c}function g(a,c){var d=0;b.each(a,function(a,b){c(a,b,d++)})}function h(a){var c,d;if("object"!=typeof a)throw new Error("Please supply an object of options");if(!a.message)throw new Error("Please specify a message");return a=b.extend({},o,a),a.buttons||(a.buttons={}),a.backdrop=a.backdrop?"static":!1,c=a.buttons,d=f(c),g(c,function(a,e,f){if(b.isFunction(e)&&(e=c[a]={callback:e}),"object"!==b.type(e))throw new Error("button with key "+a+" must be an object");e.label||(e.label=a),e.className||(e.className=2>=d&&f===d-1?"btn-primary":"btn-default")}),a}function i(a,b){var c=a.length,d={};if(1>c||c>2)throw new Error("Invalid argument length");return 2===c||"string"==typeof a[0]?(d[b[0]]=a[0],d[b[1]]=a[1]):d=a[0],d}function j(a,c,d){return b.extend(!0,{},a,i(c,d))}function k(a,b,c,d){var e={className:"bootbox-"+a,buttons:l.apply(null,b)};return m(j(e,d,c),b)}function l(){for(var a={},b=0,c=arguments.length;c>b;b++){var e=arguments[b],f=e.toLowerCase(),g=e.toUpperCase();a[f]={label:d(g)}}return a}function m(a,b){var d={};return g(b,function(a,b){d[b]=!0}),g(a.buttons,function(a){if(d[a]===c)throw new Error("button key "+a+" is not allowed (options are "+b.join("\n")+")")}),a}var n={dialog:"<div class='bootbox modal' tabindex='-1' role='dialog'><div class='modal-dialog'><div class='modal-content'><div class='modal-body'><div class='bootbox-body'></div></div></div></div></div>",header:"<div class='modal-header'><h4 class='modal-title'></h4></div>",footer:"<div class='modal-footer'></div>",closeButton:"<button type='button' class='bootbox-close-button close' data-dismiss='modal' aria-hidden='true'>&times;</button>",form:"<form class='bootbox-form'></form>",inputs:{text:"<input class='bootbox-input bootbox-input-text form-control' autocomplete=off type=text />",textarea:"<textarea class='bootbox-input bootbox-input-textarea form-control'></textarea>",email:"<input class='bootbox-input bootbox-input-email form-control' autocomplete='off' type='email' />",select:"<select class='bootbox-input bootbox-input-select form-control'></select>",checkbox:"<div class='checkbox'><label><input class='bootbox-input bootbox-input-checkbox' type='checkbox' /></label></div>",date:"<input class='bootbox-input bootbox-input-date form-control' autocomplete=off type='date' />",time:"<input class='bootbox-input bootbox-input-time form-control' autocomplete=off type='time' />",number:"<input class='bootbox-input bootbox-input-number form-control' autocomplete=off type='number' />",password:"<input class='bootbox-input bootbox-input-password form-control' autocomplete='off' type='password' />"}},o={locale:"en",backdrop:!0,animate:!0,className:null,closeButton:!0,show:!0,container:"body"},p={};p.alert=function(){var a;if(a=k("alert",["ok"],["message","callback"],arguments),a.callback&&!b.isFunction(a.callback))throw new Error("alert requires callback property to be a function when provided");return a.buttons.ok.callback=a.onEscape=function(){return b.isFunction(a.callback)?a.callback():!0},p.dialog(a)},p.confirm=function(){var a;if(a=k("confirm",["cancel","confirm"],["message","callback"],arguments),a.buttons.cancel.callback=a.onEscape=function(){return a.callback(!1)},a.buttons.confirm.callback=function(){return a.callback(!0)},!b.isFunction(a.callback))throw new Error("confirm requires a callback");return p.dialog(a)},p.prompt=function(){var a,d,e,f,h,i,k;f=b(n.form),d={className:"bootbox-prompt",buttons:l("cancel","confirm"),value:"",inputType:"text"},a=m(j(d,arguments,["title","callback"]),["cancel","confirm"]),i=a.show===c?!0:a.show;var o=["date","time","number"],q=document.createElement("input");if(q.setAttribute("type",a.inputType),o[a.inputType]&&(a.inputType=q.type),a.message=f,a.buttons.cancel.callback=a.onEscape=function(){return a.callback(null)},a.buttons.confirm.callback=function(){var c;switch(a.inputType){case"text":case"textarea":case"email":case"select":case"date":case"time":case"number":case"password":c=h.val();break;case"checkbox":var d=h.find("input:checked");c=[],g(d,function(a,d){c.push(b(d).val())})}return a.callback(c)},a.show=!1,!a.title)throw new Error("prompt requires a title");if(!b.isFunction(a.callback))throw new Error("prompt requires a callback");if(!n.inputs[a.inputType])throw new Error("invalid prompt type");switch(h=b(n.inputs[a.inputType]),a.inputType){case"text":case"textarea":case"email":case"date":case"time":case"number":case"password":h.val(a.value);break;case"select":var r={};if(k=a.inputOptions||[],!k.length)throw new Error("prompt with select requires options");g(k,function(a,d){var e=h;if(d.value===c||d.text===c)throw new Error("given options in wrong format");d.group&&(r[d.group]||(r[d.group]=b("<optgroup/>").attr("label",d.group)),e=r[d.group]),e.append("<option value='"+d.value+"'>"+d.text+"</option>")}),g(r,function(a,b){h.append(b)}),h.val(a.value);break;case"checkbox":var s=b.isArray(a.value)?a.value:[a.value];if(k=a.inputOptions||[],!k.length)throw new Error("prompt with checkbox requires options");if(!k[0].value||!k[0].text)throw new Error("given options in wrong format");h=b("<div/>"),g(k,function(c,d){var e=b(n.inputs[a.inputType]);e.find("input").attr("value",d.value),e.find("label").append(d.text),g(s,function(a,b){b===d.value&&e.find("input").prop("checked",!0)}),h.append(e)})}return a.placeholder&&h.attr("placeholder",a.placeholder),a.pattern&&h.attr("pattern",a.pattern),f.append(h),f.on("submit",function(a){a.preventDefault(),e.find(".btn-primary").click()}),e=p.dialog(a),e.off("shown.bs.modal"),e.on("shown.bs.modal",function(){h.focus()}),i===!0&&e.modal("show"),e},p.dialog=function(a){a=h(a);var c=b(n.dialog),d=c.find(".modal-body"),f=a.buttons,i="",j={onEscape:a.onEscape};if(g(f,function(a,b){i+="<button data-bb-handler='"+a+"' type='button' class='btn "+b.className+"'>"+b.label+"</button>",j[a]=b.callback}),d.find(".bootbox-body").html(a.message),a.animate===!0&&c.addClass("fade"),a.className&&c.addClass(a.className),a.title&&d.before(n.header),a.closeButton){var k=b(n.closeButton);a.title?c.find(".modal-header").prepend(k):k.css("margin-top","-10px").prependTo(d)}return a.title&&c.find(".modal-title").html(a.title),i.length&&(d.after(n.footer),c.find(".modal-footer").html(i)),c.on("hidden.bs.modal",function(a){a.target===this&&c.remove()}),c.on("shown.bs.modal",function(){c.find(".btn-primary:first").focus()}),c.on("escape.close.bb",function(a){j.onEscape&&e(a,c,j.onEscape)}),c.on("click",".modal-footer button",function(a){var d=b(this).data("bb-handler");e(a,c,j[d])}),c.on("click",".bootbox-close-button",function(a){e(a,c,j.onEscape)}),c.on("keyup",function(a){27===a.which&&c.trigger("escape.close.bb")}),b(a.container).append(c),c.modal({backdrop:a.backdrop,keyboard:!1,show:!1}),a.show&&c.modal("show"),c},p.setDefaults=function(){var a={};2===arguments.length?a[arguments[0]]=arguments[1]:a=arguments[0],b.extend(o,a)},p.hideAll=function(){b(".bootbox").modal("hide")};var q={br:{OK:"OK",CANCEL:"Cancelar",CONFIRM:"Sim"},da:{OK:"OK",CANCEL:"Annuller",CONFIRM:"Accepter"},de:{OK:"OK",CANCEL:"Abbrechen",CONFIRM:"Akzeptieren"},en:{OK:"OK",CANCEL:"Cancel",CONFIRM:"OK"},es:{OK:"OK",CANCEL:"Cancelar",CONFIRM:"Aceptar"},fi:{OK:"OK",CANCEL:"Peruuta",CONFIRM:"OK"},fr:{OK:"OK",CANCEL:"Annuler",CONFIRM:"D'accord"},he:{OK:"אישור",CANCEL:"ביטול",CONFIRM:"אישור"},it:{OK:"OK",CANCEL:"Annulla",CONFIRM:"Conferma"},lt:{OK:"Gerai",CANCEL:"Atšaukti",CONFIRM:"Patvirtinti"},lv:{OK:"Labi",CANCEL:"Atcelt",CONFIRM:"Apstiprināt"},nl:{OK:"OK",CANCEL:"Annuleren",CONFIRM:"Accepteren"},no:{OK:"OK",CANCEL:"Avbryt",CONFIRM:"OK"},pl:{OK:"OK",CANCEL:"Anuluj",CONFIRM:"Potwierdź"},ru:{OK:"OK",CANCEL:"Отмена",CONFIRM:"Применить"},sv:{OK:"OK",CANCEL:"Avbryt",CONFIRM:"OK"},tr:{OK:"Tamam",CANCEL:"İptal",CONFIRM:"Onayla"},zh_CN:{OK:"OK",CANCEL:"取消",CONFIRM:"确认"},zh_TW:{OK:"OK",CANCEL:"取消",CONFIRM:"確認"}};return p.init=function(c){return a(c||b)},p});
	</script>

	@yield('scripts')
</body>
</html>