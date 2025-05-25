<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Income;
use App\Models\ProfitLoss;

class AccountingController extends Controller
{
    // Show the Expense page with filtering
    public function expense(Request $request)
    {
        $query = Expense::with('expenseCategory');

        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        // Apply category filter
        if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
        }

        // Apply payment status filter
        if ($request->has('payment_status') && $request->payment_status != 'all') {
            $query->where('payment_status', $request->payment_status);
        }

        // Apply date range filter if provided
        if ($request->has('start_date') && !empty($request->start_date)) {
            $query->whereDate('date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && !empty($request->end_date)) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        // Apply type filter
        if ($request->has('type') && !empty($request->type)) {
            $query->where('type', $request->type);
        }

        $page_data['expenses'] = $query->get();
        $page_data['categories'] = ExpenseCategory::all();
        $page_data['filters'] = $request->all();

        return view('admin.accounting.expense.index', $page_data);
    }

    public function expense_create()
    {
        $page_data['categories'] = ExpenseCategory::all();
        return view('admin.accounting.expense.create', $page_data);
    }

    public function expense_store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'amount' => 'required',
            'date' => 'required',
            'description' => 'required',
            'category' => 'required',
            'payment_status' => 'required|in:paid,unpaid',
        ]);

        $expense = new Expense();
        $expense->type = $request->type;
        $expense->amount = $request->amount;
        $expense->date = $request->date;
        $expense->category = $request->category;
        $expense->description = $request->description;
        $expense->payment_status = $request->payment_status;
        $expense->save();

        return redirect()->route('admin.accounting.expense.index')->with('success', 'Expense created successfully.');
    }

    public function expense_edit($id)
    {
        $page_data['expense'] = Expense::findOrFail($id);
        $page_data['categories'] = ExpenseCategory::all();
        return view('admin.accounting.expense.edit', $page_data);
    }

    public function expense_update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required',
            'amount' => 'required',
            'date' => 'required',
            'description' => 'required',
            'category' => 'required',
            'payment_status' => 'required|in:paid,unpaid',
        ]);

        $expense = Expense::findOrFail($id);
        $expense->type = $request->type;
        $expense->amount = $request->amount;
        $expense->date = $request->date;
        $expense->category = $request->category;
        $expense->description = $request->description;
        $expense->payment_status = $request->payment_status;
        $expense->save();

        return redirect()->route('admin.accounting.expense.index')->with('success', 'Expense updated successfully.');
    }

    public function expense_delete($id)
    {
        $expense = Expense::findOrFail($id);
        $expense->delete();

        return redirect()->route('admin.accounting.expense.index')->with('success', 'Expense deleted successfully.');
    }

    public function income()
    {
        $page_data['incomes'] = Income::select(
            'income.amount',
            'users.name as student_name',
            'agents.name as agent_name',
            'categories.title as category',
            'student_details.course_type',
            'income.date',
            \DB::raw("CASE
            WHEN student_details.course_type = 'full' THEN 'Full Course'
            WHEN student_details.course_type = 'half' THEN 'Half Course'
            WHEN student_details.course_type = 'subject wise' THEN 'Subject Wise'
            ELSE 'Unknown'
            END as course_type_label")
        )
        ->join('users', 'income.user_id', '=', 'users.id')
        ->join('student_details', 'student_details.user_id', '=', 'users.id')
        ->join('users as agents', 'student_details.entrolled_by', '=', 'agents.id')
        ->join('categories', 'student_details.class_id', '=', 'categories.id')
        ->get();
        return view('admin.accounting.income.index', $page_data);
    }

    public function profitLoss()
    {
        $page_data['profitLoss'] = ProfitLoss::all();
        return view('admin.accounting.profit_loss.index', $page_data);
    }
    public function profitLossShow(ProfitLoss $id)
    {
        $page_data['profitLoss'] = ProfitLoss::find(['id' => $id]);
        return view('admin.accounting.profit_loss.show', $page_data);
    }
}
