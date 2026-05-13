<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Services\FinancialReportService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, FinancialReportService $financialService)
    {
        $query = Expense::query();

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by date
        if ($request->filled('date_from')) {
            $query->where('date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('date', '<=', $request->date_to);
        }

        $expenses = $query->orderBy('date', 'desc')->paginate(15);

        // Get categories for filter dropdown
        $categories = ['Rent', 'Electricity', 'Equipment', 'Salary', 'Other'];

        $financialMetrics = [
            'today_expenses' => $financialService->getTodayExpenses(),
            'today_income' => $financialService->getTodayIncome(),
            'today_profit' => $financialService->getTodayProfit(),
        ];

        return view('expenses.index', compact('expenses', 'categories', 'financialMetrics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ['Rent', 'Electricity', 'Equipment', 'Salary', 'Other'];
        return view('expenses.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|in:Rent,Electricity,Equipment,Salary,Other',
            'date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        Expense::create($request->all());

        return redirect()->route('expenses.index')->with('success', 'Expense added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        $categories = ['Rent', 'Electricity', 'Equipment', 'Salary', 'Other'];
        return view('expenses.edit', compact('expense', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|in:Rent,Electricity,Equipment,Salary,Other',
            'date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        $expense->update($request->all());

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');
    }
}
