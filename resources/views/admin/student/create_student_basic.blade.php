<div class="row mb-3">
    <label for="user-name" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Name') }}<span class="text-danger ms-1">*</span></label>
    <div class="col-sm-8">
        <input type="text" name="name" class="form-control ol-form-control" id="user-name" @isset($student->name) value="{{ $student->name }}" @endisset required>
    </div>
</div>


<div class="row mb-3">
    <label for="short_description" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Biography') }}</label>
    <div class="col-sm-8">
        <textarea name="about" rows="3" class="form-control ol-form-control" id="short_description">@isset($student->about){{ $student->about }}@endisset</textarea>
    </div>
</div>


<div class="row mb-3">
    <label for="user-phone" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Phone') }}</label>
    <div class="col-sm-8">
        <input type="text" name="phone" class="form-control ol-form-control" id="user-phone" @isset($student->phone) value="{{ $student->phone }}" @endisset>
    </div>
</div>

<div class="row mb-3">
    <label for="user-address" class="form-label ol-form-label col-sm-2 col-form-label">Street</label>
    <div class="col-sm-8">
        <input type="text" name="street" class="form-control ol-form-control" id="user-address" @isset($student_details->street) value="{{ $student_details->street }}" @endisset>
    </div>
</div>
<div class="row mb-3">
    <label for="user-address" class="form-label ol-form-label col-sm-2 col-form-label">City</label>
    <div class="col-sm-8">
        <input type="text" name="city" class="form-control ol-form-control" id="user-address" @isset($student_details->city) value="{{ $student_details->city }}" @endisset>
    </div>
</div>
<div class="row mb-3">
    <label for="user-address" class="form-label ol-form-label col-sm-2 col-form-label">State</label>
    <div class="col-sm-8">
        <input type="text" name="state" class="form-control ol-form-control" id="user-address" @isset($student_details->state) value="{{ $student_details->state }}" @endisset>
    </div>
</div>
<div class="row mb-3">
    <label for="user-address" class="form-label ol-form-label col-sm-2 col-form-label">Country</label>
    <div class="col-sm-8">
        <input type="text" name="country" class="form-control ol-form-control" id="user-address" @isset($student_details->country) value="{{ $student_details->country }}" @endisset>
    </div>
</div>
<div class="row mb-3">
    <label for="user-address" class="form-label ol-form-label col-sm-2 col-form-label">Pin Code</label>
    <div class="col-sm-8">
        <input type="text" name="pincode" class="form-control ol-form-control" id="user-address" @isset($student_details->pincode) value="{{ $student_details->pincode }}" @endisset>
    </div>
</div>
<div class="row mb-3">
    <label for="user-address" class="form-label ol-form-label col-sm-2 col-form-label">Birth Date</label>
    <div class="col-sm-8">
        <input type="date" name="birth_date" class="form-control ol-form-control" id="user-address" @isset($student_details->birth_date) value="{{ $student_details->birth_date }}" @endisset>
    </div>
</div>
<div class="row mb-3">
    <label for="user-address" class="form-label ol-form-label col-sm-2 col-form-label">Parent Email Id</label>
    <div class="col-sm-8">
        <input type="text" name="parent_email" class="form-control ol-form-control" id="user-address" @isset($student_details->parent_email) value="{{ $student_details->parent_email }}" @endisset>
    </div>
</div>
<div class="row mb-3">
    <label class="form-label ol-form-label col-sm-2 col-form-label" for="multiple_user_id">Classes<span class="required text-danger">*</span>
    </label>
    <div class="col-sm-8">
    <select class="ol-select2 select2-hidden-accessible" name="user_id[]" multiple="multiple" required>
        @foreach ($category as $cate)
            <option value="{{$cate->id}}">{{$cate->title}}</option>
        @endforeach
    </select>
    </div>

</div>
<div class="row mb-3">
    <label for="photo" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('User image') }}</label>
    <div class="col-sm-8">
        <input type="file" name="photo" class="form-control ol-form-control" id="photo">
    </div>
</div>
