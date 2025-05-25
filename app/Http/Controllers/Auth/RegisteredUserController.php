<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\StudentDetails; // Ensure this class exists in the specified namespace
use App\Models\Category;
use App\Models\Role;
use App\Models\Income;
use App\Models\Expense;
use App\Models\Enrollment;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $page_data['category'] = Category::all();
        $page_data['agents'] = User::whereHas('role', function ($query) {
            $query->where('name', 'agent');
        })->get();
        return view('auth.register', $page_data);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // dd($request->subjects);
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            \DB::beginTransaction();

            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role'  => 'student',
                'role_id' => Role::where('name', 'student')->first()->id,
                'status' => 1,
                'password' => Hash::make($request->password),
                'created_by' => $request->agent_id ?? null
            ]);

            // Create student details
            $user_details = StudentDetails::create([
                'user_id' => $user->id,
                'birth_date' => $request->birth_date,
                'street' => $request->street,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'pincode' => $request->pincode,
                'parent_email' => $request->parent_email,
                /* 'class_id' => $request->class_id,
                'course_type' => $request->course_type,
                'subject_id' => is_array($request->subjects) && !empty($request->subjects) ? implode(',', $request->subjects) : "",
                'entrolled_by' => $request->agent_id ?? null,
                'amount' => $request->amount ?? 0, */
                'photo' => null
            ]);

            /* if (is_array($request->subjects) && !empty($request->subjects)) {
                foreach ($request->subjects as $subjectId) {
                    $enrollmentData = [
                        'user_id'    => $user->id,
                        'course_id'  => $subjectId,
                        'entry_date' => time(),
                    ];
                    Enrollment::insert($enrollmentData);
                }
            }

            // Record the income
            $amount = $request->amount ?? 0;
            if ($amount > 0) {
                Income::create([
                    'user_id' => $user->id,
                    'amount' => $amount,
                    'date' => now()
                ]);
            }

            // Calculate and record the agent commission if an agent is involved
            if ($request->agent_id) {
                $agent = User::find($request->agent_id);
                if ($agent && $amount > 0) {
                    // Get the agent's revenue percentage
                    $revenuePercentage = $agent->revenue ?? 0;

                    // Calculate commission amount
                    $commissionAmount = ($amount * $revenuePercentage) / 100;

                    if ($commissionAmount > 0) {
                        // Record the expense for agent commission
                        Expense::create([
                            'amount' => $commissionAmount,
                            'user_id' => $request->agent_id,
                            'date' => now(),
                            'type' => 'commission',
                            'description' => 'Agent commission for student Registration: ' . $user->name
                        ]);
                    }
                }
                $teamleader = User::find($agent->created_by);
                if ($teamleader && $amount > 0) {
                    // Get the teamleader's revenue percentage
                    $revenuePercentage = $teamleader->revenue ?? 0;

                    // Calculate commission amount
                    $commissionAmount = ($amount * $revenuePercentage) / 100;

                    if ($commissionAmount > 0) {
                        // Record the expense for agent commission
                        Expense::create([
                            'amount' => $commissionAmount,
                            'user_id' => $teamleader->id,
                            'date' => now(),
                            'type' => 'commission',
                            'description' => 'Team Leader commission for student Registration: ' . $user->name
                        ]);
                    }
                }
                $supervisor = User::find($teamleader->created_by);
                if ($supervisor && $amount > 0) {
                    // Get the supervisor's revenue percentage
                    $revenuePercentage = $supervisor->revenue ?? 0;

                    // Calculate commission amount
                    $commissionAmount = ($amount * $revenuePercentage) / 100;

                    if ($commissionAmount > 0) {
                        // Record the expense for agent commission
                        Expense::create([
                            'amount' => $commissionAmount,
                            'user_id' => $supervisor->id,
                            'date' => now(),
                            'type' => 'commission',
                            'description' => 'Supervisor commission for student Registration: ' . $user->name
                        ]);
                    }
                }
            } */

            event(new Registered($user));

            Auth::login($user);

            \DB::commit();

            return redirect(RouteServiceProvider::HOME);
        } catch (\Exception $e) {
            dd($e);
            \DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong. Please try again.')->withInput();
        }
    }
}
