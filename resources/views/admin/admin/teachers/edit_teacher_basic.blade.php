<div class="row mb-3">
    <label for="user-name" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Name') }}<span class="text-danger ms-1">*</span></label>
    <div class="col-sm-8">
        <input type="text" name="name" class="form-control ol-form-control" id="user-name" @isset($teacher->name) value="{{ $teacher->name }}" @endisset required>
    </div>
</div>


<div class="row mb-3">
    <label for="short_description" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Biography') }}</label>
    <div class="col-sm-8">
        <textarea name="about" rows="3" class="form-control ol-form-control" id="short_description">@isset($teacher->about){{ $teacher->about }}@endisset</textarea>
    </div>
</div>
ß

<div class="row mb-3">
    <label for="user-phone" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Phone') }}</label>
    <div class="col-sm-8">
        <input type="text" name="phone" class="form-control ol-form-control" id="user-phone" @isset($teacher->phone) value="{{ $teacher->phone }}" @endisset>
    </div>
</div>

<div class="row mb-3">
    <label for="user-address" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Address') }}</label>
    <div class="col-sm-8">
        <input type="text" name="address" class="form-control ol-form-control" id="user-address" @isset($teacher->address) value="{{ $teacher->address }}" @endisset>
    </div>
</div>
<div class="row mb-3">
    <label for="photo" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('User image') }}</label>
    <div class="col-sm-8">
        <input type="file" name="photo" class="form-control ol-form-control" id="photo">
    </div>
</div>
<div class="row mb-3">
    <label class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Category') }}<span
            class="text-danger ms-1">*</span></label>
    <div class="col-sm-10">
        <select class="ol-select2" name="category_id" data-minimum-results-for-search="Infinity" required>
            <option value="">{{ get_phrase('Select a category') }}</option>
            @foreach (App\Models\Category::where('parent_id', 0)->orderBy('title', 'desc')->get() as $category)
                <option value="{{ $category->id }}" @if ($teacher->category_id == $category->id) selected @endif>
                    {{ $category->title }}</option>

                @foreach ($category->childs as $sub_category)
                    <option value="{{ $sub_category->id }}" @if ($teacher->category_id == $sub_category->id) selected @endif> --
                        {{ $sub_category->title }}</option>
                @endforeach
            @endforeach
        </select>
    </div>
</div>
