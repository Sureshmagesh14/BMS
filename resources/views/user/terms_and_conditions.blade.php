<div class="container">
    <div class="modal-body">
        {{ $content->data }}
    </div>
    <div class="modal-footer hide_footer">
        <button type="button" class="btn btn-primary"
            data-url="{{ route('cashout_form') }}" data-size="xl" data-ajax-popup="true"
            data-bs-original-title="{{ __('Cashout Process') }}" data-bs-toggle="tooltip" data-value="{{ $points }}">
            Back
        </button>
    </div>
</div>