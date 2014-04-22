<div id="alerts"></div>
<div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
<div class="btn-group">
<a class="btn  btn-default dropdown-toggle" data-toggle="dropdown" title="Font"><i class="icon-font"></i><b class="caret"></b></a>
  <ul class="dropdown-menu">
  </ul>
</div>
<div class="btn-group">
<a class="btn  btn-default dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
  <ul class="dropdown-menu">
  <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
  <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
  <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
  </ul>
</div>
<div class="btn-group">
<a class="btn btn-default" data-edit="bold" title="Bold"><i class="icon-bold"></i></a>
<a class="btn btn-default" data-edit="italic" title="Italic"><i class="icon-italic"></i></a>
<a class="btn btn-default" data-edit="strikethrough" title="Strikethrough"><i class="icon-strikethrough"></i></a>
<a class="btn btn-default" data-edit="underline" title="Underline"><i class="icon-underline"></i></a>
</div>
<div class="btn-group">
<a class="btn btn-default" data-edit="insertunorderedlist" title="Bullet list"><i class="icon-list-ul"></i></a>
<a class="btn btn-default" data-edit="insertorderedlist" title="Number list"><i class="icon-list-ol"></i></a>
<a class="btn btn-default" data-edit="outdent" title="Reduce indent"><i class="icon-indent-left"></i></a>
<a class="btn btn-default" data-edit="indent" title="Indent"><i class="icon-indent-right"></i></a>
</div>
<div class="btn-group">
<a class="btn btn-default" data-edit="justifyleft" title="Align Left"><i class="icon-align-left"></i></a>
<a class="btn btn-default" data-edit="justifycenter" title="Center"><i class="icon-align-center"></i></a>
<a class="btn btn-default" data-edit="justifyright" title="Align Right"><i class="icon-align-right"></i></a>
<a class="btn btn-default" data-edit="justifyfull" title="Justify"><i class="icon-align-justify"></i></a>
</div>
<div class="btn-group">
	  <a class="btn  btn-default dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="icon-link"></i></a>
	    <div class="dropdown-menu input-append">
		    <input class="span2" placeholder="URL" type="text" data-edit="createLink"/>
		    <button class="btn  btn-default" type="button">Add</button>
</div>
<a class="btn  btn-default" data-edit="unlink" title="Remove Hyperlink"><i class="icon-cut"></i></a>

</div>

<div class="btn-group">
<a class="btn  btn-default" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="icon-picture"></i></a>
<input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
</div>
</div>

<div id="editor" class="form-control">@yield('wysiywg-content')</div>