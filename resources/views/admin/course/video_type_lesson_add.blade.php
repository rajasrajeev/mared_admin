<input type="hidden" name="lesson_type" value="system-video">
<input type="hidden" name="lesson_provider" value="system_video">
<input type="hidden" id="uploaded_video_path" name="lesson_src">

<div class="form-group mb-2">
    <label class="form-label ol-form-label">{{ get_phrase('Upload system video file') }}</label>
    <div class="input-group">
        <div class="custom-file w-100">
            <input type="file" class="form-control ol-form-control" id="system_video_file" name="system_video_file" required>
        </div>
    </div>
    <div class="progress mt-2" style="height: 20px; display: none;" id="uploadProgress">
        <div id="uploadProgressBar" class="progress-bar" style="width: 0%">0%</div>
    </div>
</div>

<div class="form-group mb-2">
    <label class="form-label ol-form-label">{{ get_phrase('Duration') }}</label>
    <input class="form-control ol-form-control duration-picker" id="duration_picker_field" name="duration">
</div>

<div class="form-group mb-2">
    <label class="form-label ol-form-label">{{ get_phrase('Caption') }} ({{ get_phrase('.vtt') }})</label>
    <div class="input-group">
        <div class="custom-file w-100">
            <input type="file" class="form-control ol-form-control" id="caption" name="caption" accept=".vtt">
        </div>
    </div>
</div>

<script>
    "use strict";
    initializeDurationPickers([".duration-picker"]);

    document.getElementById('uploadForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);
        const xhr = new XMLHttpRequest();

        const progressBar = document.getElementById('uploadProgressBar');
        const progressContainer = document.getElementById('uploadProgress');
        progressContainer.style.display = 'block';

        xhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable) {
                const percent = Math.round((e.loaded / e.total) * 100);
                progressBar.style.width = percent + '%';
                progressBar.innerText = percent + '%';
            }
        });

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                const response = JSON.parse(xhr.responseText);
                if (xhr.status === 200 && response.success) {
                    alert('Video uploaded successfully!');
                    // Store path if needed for later form submission
                    document.getElementById('uploaded_video_path').value = response.file_path;
                } else {
                    alert('Upload failed: ' + (response.error || 'Unknown error'));
                }
            }
        };

        xhr.open('POST', '{{ route("admin.upload.system.video") }}');
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        xhr.send(formData);
    });
</script>
