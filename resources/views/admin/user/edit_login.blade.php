<div class="row mb-3">
    <label for="email" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Email') }}<span class="text-danger ms-1">*</span></label>
    <div class="col-sm-8">
        <input type="email" name="email" class="form-control ol-form-control" id="email" 
            @isset($user->email) value="{{ $user->email }}" @endisset required>
    </div>
</div>

@if(!isset($user->email))
    <div class="row mb-3">
        <label for="password" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Password') }}<span class="text-danger ms-1">*</span></label>
        <div class="col-sm-8">
            <input type="password" name="password" class="form-control ol-form-control" id="password" required>
        </div>
    </div>
@endif
