@extends('layouts.default')
@push('title', get_phrase('My Dashboard'))
@push('meta')@endpush
@push('css')
<style>
    /* Main Layout Styles */
    .page-wrapper {
        display: flex;
        position: relative;
        overflow-x: hidden;
    }

    /* Sidebar Styles */
    .sidebar {
        width: 350px;
        background: #fff;
        position: fixed;
        height: 100%;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        left: -350px;
        top: 70px;
        z-index: 999;
        transition: all 0.3s ease;
    }

    .sidebar.active {
        left: 0;
    }

    .sidebar-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        z-index: 998;
        display: none;
    }

    .sidebar-overlay.active {
        display: block;
    }

    .content-area {
        width: 100%;
        transition: all 0.3s ease;
        padding: 20px;
    }

    /* Hamburger Menu */
    .hamburger-menu {
        display: inline-block;
        cursor: pointer;
        margin-right: 15px;
    }

    .hamburger-menu .bar {
        width: 25px;
        height: 3px;
        background-color: #333;
        margin: 5px 0;
        transition: 0.4s;
        border-radius: 3px;
    }

    /* Dashboard Banner Styles */
    .dashboard-banner {
        background: linear-gradient(135deg, #4d7cff 0%, #5e4dff 100%);
        color: white;
        border-radius: 16px;
        padding: 30px;
        margin-bottom: 30px;
        box-shadow: 0 10px 20px rgba(77, 124, 255, 0.1);
    }

    .dashboard-banner h2 {
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .dashboard-banner p {
        font-size: 16px;
        opacity: 0.9;
        margin-bottom: 20px;
    }

    .dashboard-stats {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-top: 15px;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        padding: 15px;
        flex: 1;
        min-width: 120px;
        backdrop-filter: blur(5px);
    }

    .stat-card h3 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .stat-card p {
        font-size: 14px;
        margin: 0;
        opacity: 0.9;
    }

    /* Content Section Styles */
    .content-section {
        margin-bottom: 40px;
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .section-title {
        font-size: 20px;
        font-weight: 600;
        margin: 0;
    }

    .view-all {
        color: #4d7cff;
        font-weight: 500;
        text-decoration: none;
    }

    /* Course Card Styles */
    .course-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .card-head {
        position: relative;
        height: 180px;
        overflow: hidden;
    }

    .card-head img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Video Section Styles */
    .video-section {
        background-color: #fff;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    /* Demo Videos Section */
    .demo-video-card {
        border-radius: 12px;
        overflow: hidden;
        position: relative;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
        cursor: pointer;
    }

    .demo-video-card .thumbnail {
        height: 180px;
        position: relative;
    }

    .demo-video-card .thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .demo-video-card .play-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(0, 0, 0, 0.5);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
    }

    .demo-video-card .video-info {
        padding: 15px;
    }

    .demo-video-card .video-info h5 {
        margin-bottom: 5px;
        font-weight: 600;
    }

    .demo-video-card .video-info p {
        color: #777;
        margin-bottom: 5px;
        font-size: 14px;
    }

    /* CTA Section */
    .cta-section {
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        border-radius: 16px;
        padding: 40px;
        color: white;
        margin-bottom: 30px;
        text-align: center;
        box-shadow: 0 10px 20px rgba(37, 117, 252, 0.2);
    }

    .cta-section h3 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 15px;
    }

    .cta-section p {
        font-size: 16px;
        opacity: 0.9;
        margin-bottom: 25px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .cta-btn {
        background: white;
        color: #2575fc;
        font-weight: 600;
        padding: 12px 30px;
        border-radius: 30px;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .cta-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(255, 255, 255, 0.3);
    }

    /* Continue Learning Section */
    .continue-learning {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    .eBtn {
        background: #4d7cff;
        color: white !important;
        border: none;
        padding: 10px 20px;
        border-radius: 30px;
        font-weight: 500;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
    }

    .eBtn:hover {
        background: #3a68e0;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(77, 124, 255, 0.2);
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .dashboard-stats {
            flex-direction: column;
        }

        .stat-card {
            min-width: 100%;
        }
    }
</style>
@endpush
@section('content')
    <!-- Page Wrapper -->
    <div class="page-wrapper container">
        <!-- Sidebar Overlay -->
        <div class="sidebar-overlay"></div>

        <!-- Sidebar -->
        <div class="sidebar">
            @include('frontend.default.student.left_sidebar')
        </div>

        <!-- Content Area -->
        <div class="content-area">
            <div class="container-fluid">
                <!-- Top Navigation Bar with Hamburger Menu -->
                <div class="d-flex align-items-center mb-4">
                    <div class="hamburger-menu">
                        <div class="bar"></div>
                        <div class="bar"></div>
                        <div class="bar"></div>
                    </div>
                    <h4 class="mb-0">{{ get_phrase('My Dashboard') }}</h4>
                </div>

                <!-- Dashboard Banner -->
                <div class="dashboard-banner">
                    <div class="row">
                        <div class="col-md-8">
                            <h2>{{ get_phrase('Welcome back') }}, {{ auth()->user()->name }}!</h2>
                            <p>{{ get_phrase('Track your learning progress and continue where you left off.') }}</p>

                            <div class="dashboard-stats">
                                <div class="stat-card">
                                    <h3>{{ count($my_courses) }}</h3>
                                    <p>{{ get_phrase('Enrolled Courses') }}</p>
                                </div>

                                @php
                                    $completed_courses = 0;
                                    foreach($my_courses as $course) {
                                        $progress = progress_bar($course->course_id);
                                        if($progress == 100) {
                                            $completed_courses++;
                                        }
                                    }
                                @endphp

                                <div class="stat-card">
                                    <h3>{{ $completed_courses }}</h3>
                                    <p>{{ get_phrase('Completed') }}</p>
                                </div>

                                @php
                                    $in_progress = count($my_courses) - $completed_courses;
                                @endphp

                                <div class="stat-card">
                                    <h3>{{ $in_progress }}</h3>
                                    <p>{{ get_phrase('In Progress') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/frontend/default/image/dashboard-illustration.svg') }}" alt="dashboard" class="img-fluid" style="max-height: 150px;">
                        </div>
                    </div>
                </div>

                <!-- Continue Learning Section -->
                @php
                    $latest_course = $my_courses->first();
                    if($latest_course) {
                        $latest_watch = App\Models\Watch_history::where('course_id', $latest_course->course_id)
                            ->where('student_id', auth()->user()->id)
                            ->first();

                        $latest_lesson = App\Models\Lesson::where('course_id', $latest_course->course_id)
                            ->orderBy('sort', 'asc')
                            ->first();

                        if (!$latest_watch && !$latest_lesson) {
                            $latest_url = route('course.player', ['slug' => $latest_course->slug]);
                        } else {
                            if ($latest_watch) {
                                $latest_lesson_id = $latest_watch->watching_lesson_id;
                            } elseif ($latest_lesson) {
                                $latest_lesson_id = $latest_lesson->id;
                            }
                            $latest_url = route('course.player', ['slug' => $latest_course->slug, 'id' => $latest_lesson_id]);
                        }
                    }
                @endphp

                @if(isset($latest_course))
                <div class="video-section continue-learning">
                    <div class="section-header">
                        <h3 class="section-title">{{ get_phrase('Continue Learning') }}</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ get_image($latest_course->thumbnail) }}" alt="course-thumbnail" class="img-fluid rounded">
                        </div>
                        <div class="col-md-8">
                            <h4>{{ ucfirst($latest_course->title) }}</h4>
                            <div class="d-flex align-items-center mt-2 mb-3">
                                <img src="{{ get_image($latest_course->user_photo) }}" alt="author-image" class="rounded-circle" style="width: 30px; height: 30px;">
                                <p class="ms-2 mb-0">{{ $latest_course->user_name }}</p>
                            </div>

                            @php
                                $latest_progress = progress_bar($latest_course->course_id);
                            @endphp

                            <div class="single-progress">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="mb-0">{{ get_phrase('Progress') }}</h6>
                                    <p class="mb-0">{{ $latest_progress }}%</p>
                                </div>
                                <div class="progress" role="progressbar" aria-valuenow="{{ $latest_progress }}" aria-valuemin="0" aria-valuemax="100" style="height: 8px;">
                                    <div class="progress-bar" style="width: {{ $latest_progress }}%"></div>
                                </div>
                            </div>

                            <a href="{{ $latest_url }}" class="eBtn learn-btn mt-3">
                                {{ $latest_progress > 0 ? get_phrase('Continue Learning') : get_phrase('Start Now') }}
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Demo Videos Section -->
                <div class="content-section">
                    <div class="section-header">
                        <h3 class="section-title">{{ get_phrase('Featured Demo Videos') }}</h3>
                        <a href="{{ route('my.courses') }}" class="view-all">{{ get_phrase('View All') }}</a>
                    </div>
                    <div class="row">
                        @php
                            // Get current student's details
                            $student_details = \App\Models\StudentDetails::where('user_id', auth()->id())->first();
                            $subject_ids = [];

                            if ($student_details) {
                                // Handle different course types
                                if ($student_details->course_type == 'full') {
                                    // For full course type, get all subjects in full courses
                                    $subject_ids = \App\Models\Course::where('course_type', 'full')->pluck('id')->toArray();
                                } elseif ($student_details->course_type == 'subject') {
                                    // For subject course type, get only the specific subject_id
                                    $subject_ids = [$student_details->subject_id];
                                } elseif ($student_details->course_type == 'half') {
                                    // For half course type, get subjects in half courses
                                    $subject_ids = \App\Models\Course::where('course_type', 'half')->pluck('id')->toArray();
                                }
                            }

                            // Get demo videos that match student's course type and subjects
                            $demo_videos = \App\Models\DemoVideo::whereIn('subject_id', $subject_ids)
                                        ->orderBy('created_at', 'desc')
                                        ->take(3)
                                        ->get();

                            // If no videos found for student's course or not logged in, get any demo videos
                            if(count($demo_videos) == 0) {
                                $demo_videos = \App\Models\DemoVideo::orderBy('created_at', 'desc')
                                            ->take(3)
                                            ->get();
                            }
                        @endphp

                        @if(count($demo_videos) > 0)
                            @foreach($demo_videos as $video)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="demo-video-card">
                                    <div class="thumbnail">
                                        <img src="{{ asset($video->thumbnail) }}" alt="{{ $video->title }}">
                                        <div class="play-icon" data-bs-toggle="modal" data-bs-target="#videoModal{{ $video->id }}">
                                            <i class="fas fa-play"></i>
                                        </div>
                                    </div>
                                    <div class="video-info">
                                        <h5>{{ $video->title }}</h5>
                                        <p>{{ $video->instructor }}</p>
                                        <span class="badge bg-light text-dark">{{ $video->duration }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Video Modal -->
                            <div class="modal fade" id="videoModal{{ $video->id }}" tabindex="-1" aria-labelledby="videoModalLabel{{ $video->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="videoModalLabel{{ $video->id }}">{{ $video->title }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-0">
                                            <video id="videoPlayer{{ $video->id }}" class="video-js vjs-big-play-centered w-100" controls preload="auto" data-setup='{}'>
                                                <source src="{{ asset($video->video_url) }}" type="video/mp4">
                                                <p class="vjs-no-js">
                                                    {{ get_phrase('To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video') }}
                                                </p>
                                            </video>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="col-12">
                                <div class="empty-state text-center py-5">
                                    <img src="{{ asset('assets/frontend/default/image/empty_state.svg') }}" alt="No Videos" class="mb-3" width="150">
                                    <p>{{ get_phrase('No demo videos available at the moment.') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Call to Action -->
                <div class="cta-section">
                    <h3>{{ get_phrase('Ready to expand your knowledge?') }}</h3>
                    <p>{{ get_phrase('Browse our extensive course catalog and find the perfect courses to enhance your skills and advance your career.') }}</p>
                    <a href="{{ route('cart') }}" class="cta-btn">{{ get_phrase('Browse Available Courses') }}</a>
                </div>

                <!-- My Courses Section -->
                <div class="content-section">
                    <div class="section-header">
                        <h3 class="section-title">{{ get_phrase('My Courses') }}</h3>
                        <a href="{{ route('my.courses') }}" class="view-all">{{ get_phrase('View All') }}</a>
                    </div>

                    <div class="row">
                        @foreach ($my_courses->take(3) as $course)
                            @php
                                $course_progress = progress_bar($course->course_id);

                                $watch_history = App\Models\Watch_history::where('course_id', $course->course_id)
                                    ->where('student_id', auth()->user()->id)
                                    ->first();

                                $lesson = App\Models\Lesson::where('course_id', $course->course_id)
                                    ->orderBy('sort', 'asc')
                                    ->first();

                                if (!$watch_history && !$lesson) {
                                    $url = route('course.player', ['slug' => $course->slug]);
                                } else {
                                    if ($watch_history) {
                                        $lesson_id = $watch_history->watching_lesson_id;
                                    } elseif ($lesson) {
                                        $lesson_id = $lesson->id;
                                    }
                                    $url = route('course.player', ['slug' => $course->slug, 'id' => $lesson_id]);
                                }
                            @endphp

                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card course-card">
                                    <div class="card-head">
                                        <img src="{{ get_image($course->thumbnail) }}" alt="course-thumbnail" class="img-fluid">
                                        <div class="course-progress-badge" style="position: absolute; top: 10px; right: 10px; background: rgba(0,0,0,0.6); color: white; padding: 5px 10px; border-radius: 20px; font-size: 12px;">
                                            {{ $course_progress }}% {{ get_phrase('Complete') }}
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img src="{{ get_image($course->user_photo) }}" alt="author-image" class="rounded-circle" style="width: 30px; height: 30px;">
                                            <h6 class="ms-2 mb-0">{{ $course->user_name }}</h6>
                                        </div>

                                        <div class="entry-title">
                                            <a href="{{ route('course.details', $course->slug) }}">
                                                <h5 class="w-100 ellipsis-line-2">{{ ucfirst($course->title) }}</h5>
                                            </a>
                                        </div>

                                        <div class="progress mt-3" style="height: 5px;">
                                            <div class="progress-bar" style="width: {{ $course_progress }}%"></div>
                                        </div>

                                        <a href="{{ $url }}" class="eBtn learn-btn w-100 text-center mt-3">
                                            {{ $course_progress > 0 ? get_phrase('Continue') : get_phrase('Start Now') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @if ($my_courses->count() == 0)
                            <div class="col-12">
                                <div class="bg-white radius-10 p-4 text-center">
                                    @include('frontend.default.empty')
                                    <a href="{{ route('my.courses') }}" class="eBtn mt-4">{{ get_phrase('Browse Courses') }}</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Payment Status Section (for courses pending approval) -->
                <div class="content-section">
                    <div class="section-header">
                        <h3 class="section-title">{{ get_phrase('Payment Status') }}</h3>
                    </div>

                    @php
                        $student_details = \App\Models\StudentDetails::where('user_id', auth()->id())->first();
                        $pending_payments = [
                            [
                                'id' => 1,
                                'course_title' => $student_details->course_type == 'full' ? 'Full Course' : ($student_details->course_type == 'subject' ? 'Subject Course' : 'Half Course'),
                                'payment_date' => $student_details->created_at->format('d M, Y'),
                                'amount' => $student_details->amount,
                                'status' => $student_details->paid == 0 ? 'Not Paid' : 'Pending Approval'
                            ]
                        ];
                    @endphp

                    @if(count($pending_payments) > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>{{ get_phrase('Course') }}</th>
                                        <th>{{ get_phrase('Date') }}</th>
                                        <th>{{ get_phrase('Amount') }}</th>
                                        <th>{{ get_phrase('Status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pending_payments as $payment)
                                        <tr>
                                            <td>{{ $payment['course_title'] }}</td>
                                            <td>{{ $payment['payment_date'] }}</td>
                                            <td>{{ $payment['amount'] }}</td>
                                            <td><span class="badge bg-warning">{{ $payment['status'] }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-4 text-center">
                            <p>{{ get_phrase('No pending payments') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        // Hamburger menu toggle
        $('.hamburger-menu').on('click', function() {
            $('.sidebar').toggleClass('active');
            $('.sidebar-overlay').toggleClass('active');
        });

        // Close sidebar when clicking overlay
        $('.sidebar-overlay').on('click', function() {
            $('.sidebar').removeClass('active');
            $('.sidebar-overlay').removeClass('active');
        });

        // Initialize video player for demo videos (placeholder)
        $('.demo-video-card').on('click', function() {
            // You would implement video playback here
            alert('Video player functionality will be implemented here');
        });
    });
</script>
@endpush
