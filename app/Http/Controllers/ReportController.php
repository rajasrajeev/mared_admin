<?php

namespace App\Http\Controllers;

use App\Models\Payment_history;
use App\Models\Income;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function admin_revenue(Request $request)
    {
        if ($request->eDateRange) {
            $date                    = explode('-', $request->eDateRange);
            $start_date              = strtotime($date[0] . ' 00:00:00');
            $end_date                = strtotime($date[1] . ' 23:59:59');
            $page_data['start_date'] = $start_date;
            $page_data['end_date']   = $end_date;

            $page_data['reports'] = Payment_history::where('admin_revenue', '!=', '')->where('created_at', '>=', date('Y-m-d H:i:s', $start_date))
                ->where('created_at', '<=', date('Y-m-d H:i:s', $end_date))
                ->latest('id')->paginate(10)->appends($request->query());
        } else {
            $start_date              = strtotime('first day of this month');
            $end_date                = strtotime('last day of this month');
            $page_data['start_date'] = $start_date;
            $page_data['end_date']   = $end_date;
            $page_data['reports']    = Payment_history::where('admin_revenue', '!=', '')->where('created_at', '>=', date('Y-m-d H:i:s', $start_date))
                ->where('created_at', '<=', date('Y-m-d H:i:s', $end_date))->latest('id')->paginate(10);
        }

        return view('admin.report.admin_revenue', $page_data);
    }

    public function admin_revenue_filter(Request $request)
    {
        if ($request->eDateRange) {
            $date                            = explode('-', $request->eDateRange);
            $start_date                      = strtotime($date[0] . ' 00:00:00');
            $end_date                        = strtotime($date[1] . ' 23:59:59');
            $page_data['start_date']         = $start_date;
            $page_data['end_date']           = $end_date;
            $page_data['reports'] = Payment_history::where('admin_revenue', '!=', '')->where('created_at', '>=', date('Y-m-d H:i:s', $start_date))
                ->where('created_at', '<=', date('Y-m-d H:i:s', $end_date))
                ->latest('id')->paginate(10)->appends($request->query());
        } else {
            $start_date              = strtotime('first day of this month');
            $end_date                = strtotime('last day of this month');
            $page_data['start_date'] = $start_date;
            $page_data['end_date']   = $end_date;
            $page_data['reports']    = Payment_history::where('admin_revenue', '!=', '')->where('created_at', '>=', date('Y-m-d H:i:s', $start_date))
                ->where('created_at', '<=', date('Y-m-d H:i:s', $end_date))
                ->latest('id')->paginate(10);
        }
        return view('admin.report.admin_revenue');
    }

    public function instructor_revenue(Request $request)
    {
        $page_data = [];

        if ($request->eDateRange) {
            $date = explode('-', $request->eDateRange);
            $start_date = strtotime($date[0] . ' 00:00:00');
            $end_date = strtotime($date[1] . ' 23:59:59');
        } else {
            $start_date = strtotime('first day of this month');
            $end_date = strtotime('last day of this month');
        }

        $page_data['start_date'] = $start_date;
        $page_data['end_date'] = $end_date;

        $user = auth()->user();
        $user_role = $user->role;

        $query = Income::select(
            'income.id',
            'income.amount',
            'income.date',
            'students.id as student_id',
            'students.name as student_name',
            'categories.title as category',
            'student_details.course_type'
        )
        ->join('users as students', 'income.user_id', '=', 'students.id')
        ->join('student_details', 'student_details.user_id', '=', 'students.id')
        ->join('categories', 'student_details.class_id', '=', 'categories.id');

        $query->addSelect(
            'agents.id as agent_id',
            'agents.name as agent_name',
            'agents.revenue as agent_revenue_percentage',
            \DB::raw("(income.amount * agents.revenue / 100) as agent_revenue")
        )
        ->join('users as agents', 'student_details.entrolled_by', '=', 'agents.id');

        $query->addSelect(
            'teamleader.id as teamleader_id',
            'teamleader.name as teamleader_name',
            'teamleader.revenue as teamleader_revenue_percentage',
            \DB::raw("(income.amount * teamleader.revenue / 100) as teamleader_revenue")
        )
        ->join('users as teamleader', 'agents.created_by', '=', 'teamleader.id');

        $query->addSelect(
            'supervisor.id as supervisor_id',
            'supervisor.name as supervisor_name',
            'supervisor.revenue as supervisor_revenue_percentage',
            \DB::raw("(income.amount * supervisor.revenue / 100) as supervisor_revenue")
        )
        ->join('users as supervisor', 'teamleader.created_by', '=', 'supervisor.id');

        if ($user_role == 'agent') {
            $query->where('agents.id', $user->id);
        } elseif ($user_role == 'supervisor') {
            $query->where('supervisor.id', $user->id);
        } elseif ($user_role == 'teamleader') {
            $query->where('teamleader.id', $user->id);
        }

        $page_data['reports'] = $query->paginate(10)->appends($request->query());

        return view('admin.report.instructor_revenue', $page_data);
    }

    public function purchase_history(Request $request)
    {
        if ($request->eDateRange) {
            $date                          = explode('-', $request->eDateRange);
            $start_date                    = strtotime($date[0] . ' 00:00:00');
            $end_date                      = strtotime($date[1] . ' 23:59:59');
            $page_data['start_date']       = $start_date;
            $page_data['end_date']         = $end_date;
            $page_data['reports'] = Payment_history::where('created_at', '>=', date('Y-m-d H:i:s', $start_date))
                ->where('created_at', '<=', date('Y-m-d H:i:s', $end_date))
                ->latest('id')->paginate(10)->appends($request->all());
        } else {
            $start_date              = strtotime('first day of this month');
            $end_date                = strtotime('last day of this month');
            $page_data['start_date'] = $start_date;
            $page_data['end_date']   = $end_date;
            $page_data['reports']    = Payment_history::where('created_at', '>=', date('Y-m-d H:i:s', $start_date))
                ->where('created_at', '<=', date('Y-m-d H:i:s', $end_date))
                ->latest('id')->paginate(10);
        }
        return view('admin.report.purchase_history', $page_data);
    }

    public function purchase_history_invoice($id = '')
    {
        $page_data['report'] = Payment_history::where('id', $id)->first();
        return view('admin.report.report_invoice', $page_data);
    }
}
