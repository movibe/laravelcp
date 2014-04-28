 @yield('styles')
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">{{ $title }}</h4>
		@yield('model-subtitle')
		<div class="pull-right">
			@yield('model-buttons')
		</div>
      </div>
      <div class="modal-body">
		@include(Theme::path('notifications'))
		@yield('content')
      </div>
  </div>
 @yield('scripts')