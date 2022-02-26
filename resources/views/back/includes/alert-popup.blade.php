
@if(session()->get('flash_s'))
    <div class="alert alert-success alert-dismissible flashAlertOnLoad">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ session()->get('flash_s') }}
    </div>
@endif

@if(session()->get('flash_e'))
    <div class="alert alert-danger alert-dismissible flashAlertOnLoad">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ session()->get('flash_e') }}
    </div>
@endif

<div class="alert alert-danger validation-popup" role="alert" style="display: none;">
    <span></span>
</div>

<div class="alert alert-success success-popup" role="alert" style="display: none;">
    <span></span>
</div>