<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the expenses.
     */
    public function index()
    {
        $brokerId = Auth::id();
        $expenses = Expense::where('broker_id', $brokerId)->paginate(15);
        return view('pages.expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new expense.
     */
    public function create()
    {
        return view('pages.expenses.create');
    }

    /**
     * Store a newly created expense in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'amount'    => 'required|numeric',
            'date'      => 'nullable|date',
            'for'       => 'required|string|max:255',
            'note'      => 'nullable|string',
        ]);

        // Compute week number from date if provided (extract ISO week number or week of year)
        if (!empty($data['date'])) {
            try {
                $dt = \Carbon\Carbon::parse($data['date']);
                $data['week'] = (int)$dt->format('W');
            } catch (\Throwable $e) {
                // if parse fails, leave week null
                $data['week'] = null;
            }
        } else {
            $data['week'] = null;
        }

        $data['broker_id'] = Auth::id();

        Expense::create($data);
        return redirect()->route('expenses.index')->with('success', 'Expense created.');
    }

    /**
     * Display the specified expense.
     */
    public function show(Expense $expense)
    {
        $this->authorize('view', $expense);
        return view('pages.expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified expense.
     */
    public function edit(Expense $expense)
    {
        $this->authorize('update', $expense);
        return view('pages.expenses.edit', compact('expense'));
    }

    /**
     * Update the specified expense in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $this->authorize('update', $expense);
        $data = $request->validate([
            'amount'    => 'required|numeric',
            'date'      => 'nullable|date',
            'for'       => 'required|string|max:255',
            'note'      => 'nullable|string',
        ]);

        if (!empty($data['date'])) {
            try {
                $dt = \Carbon\Carbon::parse($data['date']);
                $data['week'] = (int)$dt->format('W');
            } catch (\Throwable $e) {
                $data['week'] = $expense->week;
            }
        }

        $expense->update($data);
        return redirect()->route('expenses.index')->with('success', 'Expense updated.');
    }

    /**
     * Remove the specified expense from storage.
     */
    public function destroy(Expense $expense)
    {
        $this->authorize('delete', $expense);
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense deleted.');
    }
}
