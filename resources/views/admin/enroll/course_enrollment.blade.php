@extends('layouts.admin')
@push('title', get_phrase('Course enrollment'))
@push('meta')@endpush
@push('css')
<style>
    /* Form styling */
    .form-section {
        border: 1px solid #eaeaea;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        background-color: #fbfbfb;
    }

    .form-section-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
        color: #444;
    }

    .form-check {
        margin-bottom: 8px;
        padding-left: 28px;
    }

    .form-check-input {
        width: 18px;
        height: 18px;
        margin-left: -28px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }
</style>
@endpush
@section('content')
    @php
        $courses = App\Models\Course::where('status', 'active')->orWhere('status', 'private')->orderBy('title', 'asc')->get();
        $students = App\Models\User::where('role', 'student')->orderBy('name', 'asc')->get();
        $class = App\Models\Category::get();
    @endphp

    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Enroll Students') }}
                </h4>
                <a href="{{ route('admin.student.create') }}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-plus"></span>
                    <span>{{ get_phrase('Sign Up New Student') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="ol-card p-4">
                <h3 class="title fs-14px mb-3">{{get_phrase('Enroll students')}}</h3>
                <div class="ol-card-body">
                    <form class="" action="{{ route('admin.student.post') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-section">
                            <h5 class="form-section-title">{{ get_phrase('Student Selection') }}</h5>
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="multiple_user_id">{{ get_phrase('Students') }}<span class="required text-danger">*</span></label>
                                <select class="ol-select2 select2-hidden-accessible" name="user_id" required>
                                    @foreach ($students as $student)
                                        <option value="{{$student->id}}">{{$student->name}} ({{$student->email}})</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <!-- Add Quick Sign Up Form -->
                            <div class="mt-4">
                                <h6 class="form-section-title">{{ get_phrase('Quick Sign Up') }}</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="new_student_name" class="form-label">{{ get_phrase('Name') }}<span class="required text-danger">*</span></label>
                                            <input type="text" class="form-control" id="new_student_name" name="new_student_name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="new_student_email" class="form-label">{{ get_phrase('Email') }}<span class="required text-danger">*</span></label>
                                            <input type="email" class="form-control" id="new_student_email" name="new_student_email">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="new_student_password" class="form-label">{{ get_phrase('Password') }}<span class="required text-danger">*</span></label>
                                            <input type="password" class="form-control" id="new_student_password" name="new_student_password">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="new_student_phone" class="form-label">{{ get_phrase('Phone') }}</label>
                                            <input type="text" class="form-control" id="new_student_phone" name="new_student_phone">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button type="button" class="btn ol-btn-primary" id="quick_signup_btn">{{ get_phrase('Quick Sign Up') }}</button>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h5 class="form-section-title">{{ get_phrase('Course Information') }}</h5>
                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="class_id">{{ get_phrase('Select Class to Enroll') }}</label>
                                <select name="class_id" id="class_id" class="form-control" required>
                                    <option value="">-- {{ get_phrase('Select a Class') }} --</option>
                                    @foreach ($class as $course)
                                        <option value="{{ $course->id }}">{{ $course->title }}</option>
                                    @endforeach
                                </select>
                                @error('class_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="course_type">{{ get_phrase('Select Course Type') }}</label>
                                <select name="course_type" id="course_type" class="form-control" required>
                                    <option value="">-- {{ get_phrase('Select a Course Type') }} --</option>
                                    <option value="full">{{ get_phrase('Full Course') }}</option>
                                    <option value="half">{{ get_phrase('Half Course') }}</option>
                                    <option value="subject">{{ get_phrase('Subject Wise') }}</option>
                                </select>
                                @error('course_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="fpb-7 mb-3" id="subjects_container" style="display: none;">
                                <label class="form-label ol-form-label" for="subjects">{{ get_phrase('Select Subjects') }}</label>
                                <div id="subjects_list" class="mt-2">
                                    <!-- Subjects will be dynamically inserted here -->
                                </div>
                            </div>

                            <div class="fpb-7 mb-3">
                                <label class="form-label ol-form-label" for="amount">{{ get_phrase('Course Amount') }}</label>
                                <input type="number" name="amount" id="amount" class="form-control" placeholder="{{ get_phrase('Course Amount') }}" readonly>
                            </div>
                        </div>

                        <button type="submit" class="btn ol-btn-primary mt-3">{{ get_phrase('Enroll student') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Track selected subjects and their prices
        let selectedSubjects = [];
        let totalPrice = 0;

        // When class is selected
        $('#class_id').on('change', function() {
            // Reset the course type when class changes
            $('#course_type').val('');
            $('#subjects_container').hide();
            $('#amount').val('');
            selectedSubjects = [];
            totalPrice = 0;
        });

        // When course type changes
        $('#course_type').on('change', function() {
            let courseType = $(this).val();
            let classId = $('#class_id').val();
            $('#amount').val('');
            if (!classId) {
                alert('Please select a class first');
                $(this).val('');
                return;
            }

            // Reset subjects and amount
            selectedSubjects = [];
            totalPrice = 0;

            if (courseType === 'full' || courseType === 'half') {
                // Fetch price from courseTypePrice table
                fetchCourseTypePrice(classId, courseType);
                // Use readonly instead of disabled for full/half courses
                fetchSubjects(classId, courseType, true, true, true, true);
            } else if (courseType === 'subject') {
                // Show subject selection
                fetchSubjects(classId, courseType, true, true, false, false);
            } else {
                $('#subjects_container').hide();
                $('#amount').val('');
            }
        });

        // Function to fetch course type price
        function fetchCourseTypePrice(classId, courseType) {
            $.ajax({
                url: '{{ route("admin.courseType.price") }}',
                type: 'GET',
                data: {
                    class_id: classId,
                    course_type: courseType
                },
                success: function(response) {
                    $('#amount').val(response.price);
                },
                error: function(xhr) {
                    console.error("Error fetching course price:", xhr.responseText);
                    $('#amount').val('');
                }
            });
        }

        // Function to fetch subjects with prices
        function fetchSubjects(classId, courseType, showCheckbox = false, multiSelect = false, autoSelect = false, disableSelect = false) {
            $.ajax({
                url: '{{ route("admin.courses.subjects", ["classId" => ":classId", "courseType" => ":courseType"]) }}'.replace(':classId', classId).replace(':courseType', courseType),
                type: 'GET',
                success: function(response) {
                    $('#subjects_container').show();
                    $('#subjects_list').html('');

                    if (response.subjects.length > 0) {
                        response.subjects.forEach(subject => {
                            // Display price if paid
                            let priceDisplay = subject.is_paid ? ` - Price: ${subject.price}` : ' (Free)';
                            let checkedAttribute = autoSelect ? 'checked' : '';

                            // Important change: Use readonly instead of disabled for full/half courses
                            // This ensures the values are submitted with the form
                            let disabledAttribute = disableSelect ? 'readonly onclick="return false;"' : '';

                            $('#subjects_list').append(`
                                <div class="form-check">
                                    <input class="form-check-input subject-checkbox"
                                        type="checkbox"
                                        name="subjects[]"
                                        value="${subject.id}"
                                        data-price="${subject.is_paid ? subject.price : 0}"
                                        data-paid="${subject.is_paid}"
                                        id="subject_${subject.id}" ${checkedAttribute} ${disabledAttribute}>
                                    <label class="form-check-label" for="subject_${subject.id}">
                                        ${subject.title}${priceDisplay}
                                    </label>
                                </div>
                            `);
                        });

                        // Add event listeners to checkboxes
                        $('.subject-checkbox').on('change', function() {
                            updateTotalPrice();
                        });

                        // For full/half course, still calculate the total
                        if (autoSelect) {
                            updateTotalPrice();
                        }
                    } else {
                        $('#subjects_list').html('<p class="text-muted">No subjects available.</p>');
                    }
                },
                error: function(xhr) {
                    console.error("Error fetching subjects:", xhr.responseText);
                }
            });
        }

        // Function to update total price based on selected subjects
        function updateTotalPrice() {
            totalPrice = 0;
            selectedSubjects = [];

            $('.subject-checkbox:checked').each(function() {
                let subjectId = $(this).val();
                let price = parseFloat($(this).data('price')) || 0;

                selectedSubjects.push({
                    id: subjectId,
                    price: price
                });

                totalPrice += price;
            });

            // Only update amount if we're in subject-wise mode
            // For full/half course, amount comes from the courseTypePrice
            if ($('#course_type').val() === 'subject') {
                $('#amount').val(totalPrice);
            }
        }

        // Add a hidden input for course type on form submit
        $('form').on('submit', function() {
            let courseType = $('#course_type').val();

            // If it's full or half course, ensure all subject checkboxes are enabled
            // so they will be included in the form submission
            if (courseType === 'full' || courseType === 'half') {
                $('.subject-checkbox').prop('disabled', false);
            }
        });

        // Add Quick Sign Up functionality
        $('#quick_signup_btn').on('click', function() {
            let name = $('#new_student_name').val();
            let email = $('#new_student_email').val();
            let password = $('#new_student_password').val();
            let phone = $('#new_student_phone').val();

            if (!name || !email || !password) {
                alert('Please fill in all required fields');
                return;
            }

            $.ajax({
                url: '{{ route("admin.student.quick.store") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    name: name,
                    email: email,
                    password: password,
                    phone: phone
                },
                success: function(response) {
                    if (response.success) {
                        // Add the new student to the select dropdown
                        let newOption = new Option(response.student.name + ' (' + response.student.email + ')', response.student.id, true, true);
                        $('.ol-select2').append(newOption).trigger('change');
                        
                        // Clear the form
                        $('#new_student_name').val('');
                        $('#new_student_email').val('');
                        $('#new_student_password').val('');
                        $('#new_student_phone').val('');
                        
                        alert('Student created successfully!');
                    } else {
                        alert(response.message || 'Error creating student');
                    }
                },
                error: function(xhr) {
                    alert(xhr.responseJSON?.message || 'Error creating student');
                }
            });
        });
    });
</script>
@endpush
