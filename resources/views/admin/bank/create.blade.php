<form action="" method="POST">
    @csrf
    <div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12">
                    <label for="Name">{{ __('Name') }}</label>
                    <input type="text" name="name" class="form-control" required>
                  
                    <br>
                </div>
                <br>
                <div class="col-12">
                    <label for="Email">{{ __('Email') }}</label>
                    <input type="text" name="email" class="form-control" required>
                  
                    <br>
                </div>
                <div class="col-12">
                    <label for="Contact Number">{{ __('Contact Number') }}</label>
                    <input type="number" name="mobile" class="form-control" required>
                    @error('mobile')
                        <span style="color: red;" class="text-red-500">{{ $message }}</span>
                    @enderror
                    <br>
                </div>
                
            </div>
            <br>


        </div>
        <div class="modal-footer">
            <input type="button" value="{{ __('Cancel') }}" class="btn  btn-light" data-bs-dismiss="modal">
            <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary store">
        </div>
    </div>
</form>