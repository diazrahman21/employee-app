<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Get all employees
     */
    public function index()
    {
        $employees = Employee::all();
        return response()->json($employees);
    }

    /**
     * Get a single employee
     */
    public function show(Employee $employee)
    {
        return response()->json($employee);
    }

    /**
     * Store a newly created employee
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'pekerjaan' => 'required|string|max:255',
        ]);

        $employee = Employee::create($validated);
        return response()->json($employee, 201);
    }

    /**
     * Update the specified employee
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'kota' => 'sometimes|required|string|max:255',
            'pekerjaan' => 'sometimes|required|string|max:255',
        ]);

        $employee->update($validated);
        return response()->json($employee);
    }

    /**
     * Delete the specified employee
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json(null, 204);
    }

    /**
     * Get summary with UNION ALL query
     */
    public function getSummary()
    {
        try {
            $summary = DB::select("
                SELECT label, jumlah FROM (
                    SELECT pekerjaan AS label, COUNT(*) AS jumlah, 
                        CASE pekerjaan 
                            WHEN 'Programmer' THEN 1
                            WHEN 'System Analyst' THEN 2
                            WHEN 'UI/UX Designer' THEN 3
                        END as sort_order
                    FROM employees 
                    GROUP BY pekerjaan
                    UNION ALL
                    SELECT kota AS label, COUNT(*) AS jumlah,
                        CASE kota
                            WHEN 'Madrid' THEN 4
                            WHEN 'Lisbon' THEN 5
                            WHEN 'Jakarta' THEN 6
                            WHEN 'Paris' THEN 7
                            WHEN 'London' THEN 8
                        END as sort_order
                    FROM employees 
                    GROUP BY kota
                ) as combined
                WHERE sort_order IS NOT NULL
                ORDER BY sort_order
            ");

            return response()->json($summary);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
