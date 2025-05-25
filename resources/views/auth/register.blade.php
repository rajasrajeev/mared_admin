@extends('layouts.' . get_frontend_settings('theme'))
@push('title', get_phrase('Sign Up'))
@push('meta')@endpush
@push('css')
    <style>
        /* Modern form styling */
        .login-area {
            padding: 40px 0;
            background-color: #f8f9fa;
        }

        .login-form {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            padding: 30px;
            position: relative;
            margin: 0 auto;
        }

        .g-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #333;
            text-align: center;
        }

        .description {
            color: #666;
            margin-bottom: 25px;
            font-size: 16px;
            text-align: center;
        }

        .form-label {
            font-weight: 600;
            font-size: 14px;
            color: #444;
            margin-bottom: 6px;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            padding: 8px 15px;
            transition: all 0.3s ease;
            font-size: 15px;
        }

        .form-control:focus {
            border-color: #4d7cff;
            box-shadow: 0 0 0 3px rgba(77, 124, 255, 0.1);
        }

        .form-group {
            margin-bottom: 15px !important;
        }

        .eBtn {
            height: 50px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .gradient {
            background: linear-gradient(135deg, #4d7cff 0%, #5e4dff 100%);
            border: none;
            color: white;
        }

        .form-icons .right {
            top: 50%;
            transform: translateY(-50%);
            right: 15px;
            color: #aaa;
            transition: color 0.3s ease;
        }

        .text-danger {
            display: block;
            margin-top: 5px;
            font-size: 13px;
        }

        /* Form sections and card style */
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

        /* Form checkbox styling */
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

        /* Select styling */
        /* select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 16px;
            padding-right: 40px;
        } */
    </style>
@endpush
@section('content')
    <section class="login-area">
        <div class="container">
            <div class="login-form">
                <h4 class="g-title">{{ get_phrase('Create Account') }}</h4>
                <p class="description">{{ get_phrase('Join us and track your growth with personalized support') }}</p>

                <form action="{{ route('register') }}" class="global-form" method="post">@csrf
                    <div class="row">
                        <!-- <div class="col-md-4">
                            <div class="login-img">
                                <img style="height:unset;" src="{{ asset('assets/frontend/' . get_frontend_settings('theme') . '/image/signup.gif') }}" alt="register-banner">
                            </div>
                        </div> -->
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <!-- Personal Information Section -->
                            <div class="form-section">
                                <h5 class="form-section-title">{{ get_phrase('Personal Information') }}</h5>
                                <div class="form-group">
                                    <label for="name" class="form-label">{{ get_phrase('Full Name') }}</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter your full name">
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email" class="form-label">{{ get_phrase('Email Address') }}</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="your.email@example.com">
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="phone" class="form-label">{{ get_phrase('Phone Number') }}</label>
                                    <input type="number" name="phone" id="phone" class="form-control" placeholder="+974 xxxx xxxx">
                                    @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="parent_email" class="form-label">{{ get_phrase('Parent Email') }}</label>
                                    <input type="email" name="parent_email" id="parent_email" class="form-control" placeholder="parent.email@example.com">
                                    @error('parent_email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Course Information Section -->
                            <div class="form-section">
                                <h5 class="form-section-title">{{ get_phrase('Course Information') }}</h5>
                                <!-- <div class="form-group">
                                    <label for="agent_id" class="form-label">{{ get_phrase('Select Agent') }}</label>
                                    <select name="agent_id" id="agent_id" class="form-control">
                                        <option value="">-- Select an Agent --</option>
                                        @foreach ($agents as $class)
                                            <option value="{{ $class->id }}">{{ $class->name }} ({{ $class->email }})</option>
                                        @endforeach
                                    </select>
                                    @error('agent_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" id="register_with_agent" name="register_with_agent" value="1">
                                        <label class="form-check-label" for="register_with_agent">
                                            {{ get_phrase('Register under an Agent') }}
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group" id="agent_selection" style="display: none;">
                                    <label for="agent_id" class="form-label">{{ get_phrase('Select Agent') }}</label>
                                    <select name="agent_id" id="agent_id" class="form-control">
                                        <option value="">-- Select an Agent --</option>
                                        @foreach ($agents as $class)
                                            <option value="{{ $class->id }}">{{ $class->name }} ({{ $class->email }})</option>
                                        @endforeach
                                    </select>
                                    @error('agent_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div> -->

                                <div class="form-group">
                                    <label for="class_id" class="form-label">{{ get_phrase('Select Class to Enroll') }}</label>
                                    <select name="class_id" id="class_id" class="form-control">
                                        <option value="">-- Select a Class --</option>
                                        @foreach ($category as $class)
                                            <option value="{{ $class->id }}">{{ $class->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('class_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="course_type" class="form-label">{{ get_phrase('Select Course Type') }}</label>
                                    <select name="course_type" id="course_type" class="form-control">
                                        <option value="">-- Select a Course Type --</option>
                                        <option value="full">Full Course</option>
                                        <option value="half">Half Course</option>
                                        <option value="subject">Subject Wise</option>
                                    </select>
                                    @error('course_type')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group" id="subjects_container" style="display: none;">
                                    <label for="subjects" class="form-label">{{ get_phrase('Select Subjects') }}</label>
                                    <div id="subjects_list" class="mt-2">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="amount" class="form-label">{{ get_phrase('Course Amount') }}</label>
                                    <input type="number" name="amount" id="amount" class="form-control" placeholder="Course Amount" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <!-- Address Information Section -->
                            <div class="form-section">
                                <h5 class="form-section-title">{{ get_phrase('Address Information') }}</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="street" class="form-label">{{ get_phrase('Street') }}</label>
                                            <input type="text" name="street" id="street" class="form-control" placeholder="Your street address">
                                            @error('street')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="city" class="form-label">{{ get_phrase('City') }}</label>
                                            <input type="text" name="city" id="city" class="form-control" placeholder="Your city">
                                            @error('city')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="state" class="form-label">{{ get_phrase('State') }}</label>
                                            <input type="text" name="state" id="state" class="form-control" placeholder="Your state">
                                            @error('state')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="country" class="form-label">{{ get_phrase('Country') }}</label>
                                            <input type="text" name="country" id="country" class="form-control" placeholder="Your country">
                                            @error('country')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="pincode" class="form-label">{{ get_phrase('Pincode') }}</label>
                                    <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Your postal/zip code">
                                    @error('pincode')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <!-- Account Information -->
                            <div class="form-section">
                                <h5 class="form-section-title">{{ get_phrase('Account Information') }}</h5>
                                <div class="form-group">
                                    <label for="password" class="form-label">{{ get_phrase('Create Password') }}</label>
                                    <div class="position-relative">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="••••••••">
                                        <div class="position-absolute form-icons">
                                            <i class="fas fa-eye right" id="showpassword"></i>
                                        </div>
                                    </div>
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mt-3">
                            <button type="submit" class="eBtn gradient w-100">{{ get_phrase('Create Account') }}</button>
                            <p class="text-center mt-3">{{ get_phrase('Already have an account?') }} <a href="{{ route('login') }}" class="text-primary">{{ get_phrase('Sign in') }}</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script>
        "use strict";

        $(document).ready(function() {
            $('#showpassword').on('click', function(e) {
                e.preventDefault();
                const type = $('#password').attr('type');

                if (type == 'password') {
                    $('#password').attr('type', 'text');
                    $(this).removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    $('#password').attr('type', 'password');
                    $(this).removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        });

        $(document).ready(function() {
            $('#showcpassword').on('click', function(e) {
                e.preventDefault();
                const type = $('#cpassword').attr('type');

                if (type == 'password') {
                    $('#cpassword').attr('type', 'text');
                    $(this).removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    $('#cpassword').attr('type', 'password');
                    $(this).removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        });
    </script>
@endpush
@push('js')
<script>
    $(document).ready(function() {
    // Track selected subjects and their prices
    let selectedSubjects = [];
    let totalPrice = 0;

    // Toggle agent selection visibility based on checkbox
    $('#register_with_agent').on('change', function() {
        if ($(this).is(':checked')) {
            $('#agent_selection').show();
        } else {
            $('#agent_selection').hide();
            $('#agent_id').val(''); // Clear agent selection when unchecked
        }
    });

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
                console.log(response);
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
});
</script>
@endpush
