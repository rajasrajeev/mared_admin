<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\StudentDetails;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class MyCoursesController extends Controller
{
    public function index()
    {
        // Get the authenticated user ID
        $userId = auth()->user()->id;
        

        // Get the student's details with class_id and course_type
        $studentDetails = StudentDetails::where('user_id', $userId)->first();

        if (!$studentDetails) {
            // If no student details found, return an empty paginator
            $page_data['my_courses'] = new LengthAwarePaginator([], 0, 6);
            
        } else {
            // Query courses based on the student's class_id and course_type
            $my_courses = Course::join('users', 'courses.user_id', '=', 'users.id')
                ->where('courses.category_id', $studentDetails->class_id)
                ->where(function($query) use ($studentDetails) {
                    // If student enrolled in full course, show all courses
                    if ($studentDetails->course_type === 'full') {
                        return $query;
                    }
                    // If student enrolled in half course, show only half course content
                    elseif ($studentDetails->course_type === 'half') {
                        return $query->where('courses.course_type', 'half');
                    }
                    // If student enrolled in subject wise courses
                    elseif ($studentDetails->course_type === 'subject') {
                        // Get the student's selected subjects
                        $subjects = DB::table('student_subjects')
                            ->where('student_id', $studentDetails->id)
                            ->pluck('subject_id')
                            ->toArray();

                        return $query->whereIn('courses.subject_id', $subjects);
                    }
                })
                ->select(
                    'courses.id',
                    'courses.slug',
                    'courses.title',
                    'courses.thumbnail',
                    'users.name as user_name',
                    'users.photo as user_photo'
                )
                ->paginate(6);

            // The paginator is preserved, so no need to map or transform here
            $page_data['my_courses'] = $my_courses;
        }
        $view_path = 'frontend.' . get_frontend_settings('theme') . '.student.my_courses.index';
        return view($view_path, $page_data);
    }
}
