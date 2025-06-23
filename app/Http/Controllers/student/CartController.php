<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\StudentDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index(Request $request)
    {
        // has any coupon then validate coupon
        $discount = 0;
        $coupon = null;

        if (request()->has('coupon')) {
            $code   = request()->query('coupon');
            $coupon = Coupon::where('code', $code)->first();
            if (! $coupon) {
                Session::flash('error', get_phrase('This coupon is not valid.'));
                return redirect()->back();
            }

            if ($coupon->status && (time() >= $coupon->expiry)) {
                Session::flash('error', get_phrase('Ops! coupon is expired.'));
                return redirect()->back();
            }
            $discount = $coupon->discount;
            $page_data['coupon'] = $coupon;
        }

        // Get logged-in user's student details
        $user_id = auth()->user()->id;
        $student_details = StudentDetails::where('user_id', $user_id)->first();

        // cart items by course id
        $cart_items = CartItem::join('courses', 'cart_items.course_id', '=', 'courses.id')
            ->select('cart_items.id as cart_id', 'courses.*', 'courses.id as course_id')
            ->where('cart_items.user_id', $user_id)->get();

        // Calculate pricing based on student's course type
        $count_items_price = 0;

        if ($student_details) {
            $course_type = $student_details->course_type;
            $class_id = $student_details->class_id ?? null;

            if (in_array($course_type, ['full', 'half'])) {
                // For full or half course types, get price from course_type_price table
                $course_type_price = DB::table('course_type_price')
                    ->where('course_type', $course_type)
                    ->where('class_id', $class_id)
                    ->first();

                if ($course_type_price) {
                    $count_items_price = $course_type_price->price;
                } else {
                    // Fallback if no course_type_price found
                    Session::flash('warning', get_phrase('Course type pricing not found. Please contact admin.'));
                }

                // For full/half courses, disable coupon functionality
                if ($course_type === 'full' || $course_type === 'half') {
                    $discount = 0;
                    $coupon = null;
                    if (request()->has('coupon')) {
                        Session::flash('info', get_phrase('Coupons are not applicable for package courses.'));
                        return redirect()->route('cart');
                    }
                }

            } else if ($course_type === 'subject') {
                // For subject-wise, calculate from individual course prices in cart
                foreach ($cart_items as $course) {
                    if ($course->is_paid == 0) {
                        // Free course, no price to add
                        continue;
                    } else {
                        if ($course->discount_flag == 1) {
                            $count_items_price += $course->discounted_price;
                        } else {
                            $count_items_price += $course->price;
                        }
                    }
                }
            }
        } else {
            // Fallback: if no student details found, use existing cart logic
            foreach ($cart_items as $course) {
                if ($course->is_paid == 0) {
                    continue;
                } else {
                    if ($course->discount_flag == 1) {
                        $count_items_price += $course->discounted_price;
                    } else {
                        $count_items_price += $course->price;
                    }
                }
            }
        }

        // Calculate coupon discount and tax
        $coupon_discount = $count_items_price * ($discount / 100);
        $tax = (get_settings('course_selling_tax') / 100) * ($count_items_price - $coupon_discount);
        $payable = $count_items_price - $coupon_discount + $tax;

        // Prepare page data
        $page_data['cart_items'] = $cart_items;
        $page_data['discount'] = $discount;
        $page_data['count_items_price'] = $count_items_price;
        $page_data['coupon_discount'] = $coupon_discount;
        $page_data['tax'] = $tax;
        $page_data['payable'] = $payable;
        $page_data['student_details'] = $student_details;

        $view_path = 'frontend.' . get_frontend_settings('theme') . '.student.cart.index';
        return view($view_path, $page_data);
    }

    public function store($id)
    {
        // check personal course
        if (Course::where('id', $id)->where('user_id', auth()->user()->id)->exists()) {
            Session::flash('error', get_phrase('Ops! You own this course.'));
            return redirect()->back();
        }

        // check if the course is purchased or not
        if (Enrollment::where('user_id', auth()->user()->id)->where('course_id', $id)->exists()) {
            Session::flash('error', get_phrase('You already purchased the course.'));
            return redirect()->back();
        }

        // if course_id doesn't exit in cart then insert course_id
        if (CartItem::where('user_id', auth()->user()->id)->where('course_id', $id)->doesntExist()) {
            CartItem::insert(['user_id' => auth()->user()->id, 'course_id' => $id]);
        }

        // redirect back
        Session::flash('success', get_phrase('Item added to the cart.'));
        return redirect()->back();
    }

    public function delete($id)
    {
        // if user has selected item then delete item else redirect to cart page
        $query = CartItem::where('course_id', $id)->where('user_id', auth()->user()->id);

        if ($query->exists()) {
            $query->delete();
            Session::flash('success', get_phrase('Item removed from cart.'));
        } else {
            Session::flash('error', get_phrase('Data not found.'));
        }
        return redirect()->back();
    }

    public function checkoutCourse($type, $id = null)
    {
        // Get student details for the logged in user
        $studentDetails = StudentDetails::where('user_id', auth()->user()->id)->first();


        if (!$studentDetails) {
            Session::flash('error', get_phrase('Student details not found.'));
            return redirect()->back();
        }

        // Check if type matches course_type in student details
        if ($type === 'subject') {
            // For subjects, get subject IDs from student details
            $subjectIds = explode(',', $studentDetails->subject_id);


            if (!in_array($id, $subjectIds)) {
                Session::flash('error', get_phrase('Subject not found in student details.'));
                return redirect()->back();
            }

            // Add all subjects to cart
            foreach($subjectIds as $subjectId) {
                CartItem::insert([
                    'user_id' => auth()->user()->id,
                    'course_id' => $subjectId
                ]);
            }
        } else {
            // Get courses matching the type by checking if course_type contains the requested type
            $query = Course::where('category_id', $id)->where(function($query) use ($type) {
                $query->where('course_type', 'LIKE', '%'.$type.'%');
            });
            // If type is 'subject', filter by subject_id

            $courses = $query->get();

            // Add all matching courses to cart
            foreach($courses as $course) {
                CartItem::insert([
                    'user_id' => auth()->user()->id,
                    'course_id' => $course->id
                ]);
            }
        }

        return redirect()->route('cart');
    }
}
