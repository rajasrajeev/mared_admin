<div class="row mb-3">
    <label for="facebook" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Facebook') }}</label>
    <div class="col-sm-8">
        <input type="text" name="facebook" class="form-control ol-form-control" id="facebook"
            @isset($user->facebook) value="{{ $user->facebook }}" @endisset>
    </div>
</div>

<div class="row mb-3">
    <label for="twitter" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Twitter') }}</label>
    <div class="col-sm-8">
        <input type="text" name="twitter" class="form-control ol-form-control" id="twitter"
            @isset($user->twitter) value="{{ $user->twitter }}" @endisset>
    </div>
</div>

<div class="row mb-3">
    <label for="linkedin" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('LinkedIn') }}</label>
    <div class="col-sm-8">
        <input type="text" name="linkedin" class="form-control ol-form-control" id="linkedin"
            @isset($user->linkedin) value="{{ $user->linkedin }}" @endisset>
    </div>
</div>
