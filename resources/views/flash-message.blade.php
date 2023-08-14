@if ($message = Session::get('success'))
<div class="alert alert-custom alert-light-success fade show mb-5" role="alert">
    <div class="alert-icon"><i class="fa fa-check"></i></div>
    <div class="alert-text"><strong>{{ $message }}</strong></div>
    <div class="alert-close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="ki ki-close"></i></span>
        </button>
    </div>
</div>
@endif

@if ($message = Session::get('error'))
<div class="alert alert-custom alert-light-danger fade show mb-5" role="alert">
    <div class="alert-icon"><i class="flaticon-warning"></i></div>
    <div class="alert-text"><strong>{{ $message }}</strong></div>
    <div class="alert-close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="ki ki-close"></i></span>
        </button>
    </div>
</div>
@endif 
    
@if ($messages = Session::get('errors'))
    @foreach ($messages->all() as $error)
    <div class="alert alert-custom alert-light-danger fade show mb-5" role="alert">
        <div class="alert-icon"><i class="flaticon-warning"></i></div>
        <div class="alert-text">
            <strong>{{ $error }}</strong>
        </div>
        <div class="alert-close">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true"><i class="ki ki-close"></i></span>
            </button>
        </div>
    </div>
    @endforeach
@endif
     
@if ($message = Session::get('warning'))
<div class="alert alert-custom alert-light-warning fade show mb-5" role="alert">
    <div class="alert-icon"><i class="flaticon-warning"></i></div>
    <div class="alert-text"><strong>{{ $message }}</strong></div>
    <div class="alert-close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="ki ki-close"></i></span>
        </button>
    </div>
</div>
@endif
     
@if ($message = Session::get('info'))
<div class="alert alert-custom alert-light-primary fade show mb-5" role="alert">
    <div class="alert-icon"><i class="flaticon-warning"></i></div>
    <div class="alert-text"><strong>{{ $message }}</strong></div>
    <div class="alert-close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="ki ki-close"></i></span>
        </button>
    </div>
</div>
@endif