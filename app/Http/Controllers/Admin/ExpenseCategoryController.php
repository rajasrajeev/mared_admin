<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $categories = ExpenseCategory::orderBy('created_at', 'desc')->get();
        return view('admin.accounting.expense.category', compact('categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        ExpenseCategory::create([
            'title' => $request->title,
        ]);

        return redirect()->route('admin.accounting.expense.category')->with('success', 'Expense category has been added successfully!');;
    }

    public function edit($id)
    {
        $category = ExpenseCategory::findOrFail($id);
        $categories = ExpenseCategory::orderBy('created_at', 'desc')->get();
        return view('admin.accounting.expense.category', compact('categories', 'category'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $category = ExpenseCategory::findOrFail($id);
        $category->title = $request->title;
        $category->save();

        return redirect()->route('admin.accounting.expense.category')->with('success', 'Expense category has been updated successfully!');
    }

    public function delete($id)
    {
        $category = ExpenseCategory::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.accounting.expense.category')->with('success', 'Expense category has been deleted successfully!');
    }
}
