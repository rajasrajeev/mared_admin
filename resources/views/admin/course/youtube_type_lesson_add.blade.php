<input type="hidden" name="lesson_type" value="video-url">
<input type="hidden" name="lesson_provider" value="youtube">

<div class="form-group mb-2">
    <label class="form-label ol-form-label">{{ get_phrase('Video url') }}</label>
    <input type="text" id="video_url" onblur="ajax_get_video_details(this.value)" name="lesson_src" class="form-control ol-form-control">
    <small class="form-label text-danger text-12px d-hidden mb-0" id="invalid_url">{{ get_phrase('Invalid url') }}. {{ get_phrase('Your video source has to be either YouTube') }}</small>
</div>

<div class="form-group mb-2 d-none">
    <label class="form-label ol-form-label">{{ get_phrase('Duration') }}</label>
    <small class="form-label text-12px d-hidden mb-0" id="perloader"><i class="fi-rr-loading mdi-loading "></i> {{get_phrase('Analyzing')}}....</small>
    <input type="text" name="duration" id="duration" class="form-control ol-form-control" value="00:00:00" readonly>
</div>

<script>
    "use strict";
    initializeDurationPickers(["#duration"]);
</script>
