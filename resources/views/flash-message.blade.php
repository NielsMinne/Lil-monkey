
@if ($message = Session::get('success'))
<div class="animate-pulse duration-300 alert alert-success text-center bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative">
        <strong>{{ __($message) }}</strong>
</div>
@endif


@if ($message = Session::get('error'))
<div class="animate-pulse alert alert-error text-center bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative">
        <strong>{{ __($message) }}</strong>
</div>
@endif


@if ($message = Session::get('warning'))
<div class="animate-pulse alert alert-warning text-center bg-orange-100 border border-orange-400 text-orange-700 px-4 py-3 rounded-lg relative">
	
	<strong>{{ __($message) }}</strong>
</div>
@endif


@if ($message = Session::get('info'))
<div class="animate-pulse alert alert-warning text-center bg-yellow-100 border border-orange-400 text-orange-700 px-4 py-3 rounded-lg relative">
	<strong>{{ __($message) }}</strong>
</div>
@endif


@if ($errors->any())
<div class="alert animate-pulse alert alert-warning text-center bg-red-100 border border-orange-400 text-orange-700 px-4 py-3 rounded-lg relative">	
	@foreach ($errors->all() as $message)
	<strong>{{ __($message) }}</strong>
	@endforeach
</div>
    
@endif

<script src="{{ asset('js/flash.js') }}"></script>