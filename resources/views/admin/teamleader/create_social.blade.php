<div class="row mb-3">
    <label for="title" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Facebook') }}</label>
    <div class="col-sm-8">
        <input type="text" name="facebook" class="form-control ol-form-control" id="title"
            @isset($teamleader->facebook) value="{{ $teamleader->facebook }}" @endisset>
    </div>
</div>

<div class="row mb-3">
    <label for="title" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Twitter') }}</label>
    <div class="col-sm-8">
        <input type="text" name="twitter" class="form-control ol-form-control" id="title"
            @isset($teamleader->twitter) value="{{ $teamleader->twitter }}" @endisset>
    </div>
</div>
<div class="row mb-3">
    <label for="title" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Linkedin') }}</label>
    <div class="col-sm-8">
        <input type="text" name="linkedin" class="form-control ol-form-control" id="title"
            @isset($teamleader->linkedin) value="{{ $teamleader->linkedin }}" @endisset>
    </div>
</div>
