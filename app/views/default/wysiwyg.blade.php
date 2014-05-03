<script src="{{{ asset('assets/js/bootstrap-wysiwyg-start.js') }}}"></script>
<div id="alerts"></div>
<div class="hidden-md hidden-lg">
	<div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
		<div class="btn-group">
			<a class="btn btn-default" data-edit="bold" title="Bold"><i class="fa fa-bold"></i></a>
			<a class="btn btn-default" data-edit="italic" title="Italic"><i class="fa fa-italic"></i></a>
		</div>

		<div class="btn-group">
			<a class="btn btn-default" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
			<a class="btn btn-default" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
		</div>


		<div class="btn-group">
			<a class="btn btn-default" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a>
			<a class="btn  btn-default dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link">&nbsp;</i></a>
			<div class="dropdown-menu input-append" style="width: 220px">
				<div class="input-group">
					<input class="form-control" placeholder="URL" type="text" data-edit="createLink"/>
					<span class="input-group-btn">
						<button class="btn  btn-default" type="button">Add</button>
					</span>
				</div>
			</div>
		</div>

		<span class="btn btn-default btn-file">
		   <span class="fa fa-lg fa-picture-o"> </span> <input type="file" data-target="#pictureBtn" data-edit="insertImage" multiple>
		</span>
	</div>
</div>

<div class="hidden-sm hidden-xs">
	<div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">

		<div class="btn-group">
			<a class="btn  btn-default dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
			<ul class="dropdown-menu">
			</ul>
		</div>

		<div class="btn-group">
			<a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
				<li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
				<li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
			</ul>
		</div>

		<div class="btn-group">
			<a class="btn btn-default" data-edit="bold" title="Bold"><i class="fa fa-bold"></i></a>
			<a class="btn btn-default" data-edit="italic" title="Italic"><i class="fa fa-italic"></i></a>
			<a class="btn btn-default" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
			<a class="btn btn-default" data-edit="underline" title="Underline"><i class="fa fa-underline"></i></a>
		</div>

		<div class="btn-group">
			<a class="btn btn-default" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
			<a class="btn btn-default" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
			<a class="btn btn-default" data-edit="outdent" title="Reduce indent"><i class="fa fa-indent"></i></a>
			<a class="btn btn-default" data-edit="indent" title="Indent"><i class="fa fa-dedent"></i></a>
		</div>

		<div class="btn-group">
			<a class="btn btn-default" data-edit="justifyleft" title="Align Left"><i class="fa fa-align-left"></i></a>
			<a class="btn btn-default" data-edit="justifycenter" title="Center"><i class="fa fa-align-center"></i></a>
			<a class="btn btn-default" data-edit="justifyright" title="Align Right"><i class="fa fa-align-right"></i></a>
			<a class="btn btn-default" data-edit="justifyfull" title="Justify"><i class="fa fa-align-justify"></i></a>
		</div>

		<div class="btn-group">
			<a class="btn hidden-xs btn-default" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a>
			<a class="btn  btn-default dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link">&nbsp;</i></a>
			<div class="dropdown-menu input-prepend" style="width: 220px">
				<div class="input-group">
					<input class="form-control" placeholder="URL" type="text" data-edit="createLink"/>
					<span class="input-group-btn">
						<button class="btn  btn-default" type="button">Add</button>
					</span>
				</div>
			</div>
		</div>

		<span class="btn btn-default btn-file">
		   <span class="fa fa-lg fa-picture-o"> </span> <input type="file" data-target="#pictureBtn" data-edit="insertImage" multiple>
		</span>
	</div>
</div>
<br/>
<div id="editor" class="form-control">@yield('wysiywg-content')</div>