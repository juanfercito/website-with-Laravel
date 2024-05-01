<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\IncomeDetail;

class RecycleController extends Controller
{
    /**
     * Display a listing of the deleted incomes.
     */
    public function index()
    {
        // Obtener todos los ingresos eliminados
        $deletedIncomes = Income::onlyTrashed()->get();

        // Pasar los ingresos eliminados a la vista bin.blade.php
        return view('trash.bin', compact('deletedIncomes'));
    }

    /**
     * Restore the specified income from trash.
     */
    public function restore($id)
    {
        try {
            $income = Income::withTrashed()->findOrFail($id);
            $income->restore();
            return redirect()->route('trash.index')->with('success', 'Income restored successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error restoring income: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified income from trash.
     */
    public function destroy(Income $income)
    {
        try {
            $income->forceDelete();
            return redirect()->route('trash.bin')->with('success', 'Income permanently deleted');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting income permanently: ' . $e->getMessage());
        }
    }
}
