<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Deduction;
use App\Models\Allowance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PayrollController extends Controller
{
    // Display the card view for payroll records
    public function create()
    {
      //  $payrolls = Payroll::with(['allowances', 'deductions','employee'])->get(); // Load related employee data
        return view('management.payroll.payroll-create');
    }

    public function store(Request $request)
    {
       // dd($request);
        try {
            // Begin a transaction to ensure data consistency
            DB::beginTransaction();
    
            // Validate the request data
            $validated = $request->validate([
                'employee-id' => 'required|exists:employees,id',
                'salary_month' => 'required|date_format:Y-m',
                'salary_amount' => 'required|numeric|min:0',
                'bonus' => 'required|numeric|min:0',
                'total_payed' => 'required|numeric|min:0',
                'pay_date' => 'required|date',
                'work-hours' => 'nullable|integer|min:0',
                'tax_amount' => 'nullable|numeric|min:0',
                'payment_status' => 'required|string|max:255',
                'deductions' => 'array',
                'deductions.*' => 'required|json', // Each deduction must be a valid JSON string
                'allowances' => 'array',
                'allowances.*' => 'required|json',
            ]);
    
            // Create the payroll record
            $payroll = Payroll::create([
                'employee_id' => $validated['employee-id'],
                'payroll_month' => $validated['salary_month'],
                'basic_salary' => $validated['salary_amount'],
                'net_salary' => $validated['total_payed'],
                'payable' => $validated['total_payed'] - ($validated['tax_amount'] ?? 0),
                'pay_date' => $validated['pay_date'],
                'total_hours' => $validated['work-hours'],
                'tax' => $validated['tax_amount'] ?? 0,
                'bonus' => $validated['bonus'] ?? 0,
                'status' => $validated['payment_status'],
            ]);
    
            // Add deductions
       // Add deductions
if (isset($validated['deductions'])) {
    foreach ($validated['deductions'] as $deductionJson) {
        $deduction = json_decode($deductionJson, true); // Decode JSON string
        if ($deduction) { // Ensure the JSON was decoded successfully
            Deduction::create([
                'payroll_id' => $payroll->id,
                'description' => $deduction['description'],
                'amount' => $deduction['amount'],
            ]);
        }
    }
}

// Add allowances
if (isset($validated['allowances'])) {
    foreach ($validated['allowances'] as $allowanceJson) {
        $allowance = json_decode($allowanceJson, true); // Decode JSON string
        if ($allowance) { // Ensure the JSON was decoded successfully
            Allowance::create([
                'payroll_id' => $payroll->id,
                'description' => $allowance['description'],
                'amount' => $allowance['amount'],
            ]);
        }
    }
}
            // Commit the transaction
            DB::commit();
    
            return redirect()->route('payroll.management')->with('success', 'Payroll record created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Rollback the transaction
            DB::rollBack();
    dd( $e->errors(), $request->all());
            // Log the validation errors for debugging
            Log::error('Validation Error: ', $e->errors());
    
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            // Rollback the transaction
            DB::rollBack();
    
            // Log the exception for debugging
            Log::error('Error storing payroll record: ' . $e->getMessage());
    
            return redirect()->back()
                ->with('error', 'An error occurred while creating the payroll record. Please try again.')
                ->withInput();
        }
    }
    // Display details of a specific payroll record
    public function show($id)
    {
        $payroll = Payroll::with(['employee', 'allowances', 'deductions', 'bank_details'])->findOrFail($id); // Load the related employee
        return view('management.payroll.payroll-details', compact('payroll'));
    }

    public function edit($id)
{
    $payroll = Payroll::with('employee')->findOrFail($id);
    return view('management.payroll.payroll-edit', compact('payroll'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'basic_salary' => 'required|numeric',
        'allowances' => 'nullable|numeric',
        'deductions' => 'nullable|numeric',
        'net_salary' => 'required|numeric',
    ]);

    $payroll = Payroll::findOrFail($id);
    $payroll->update($request->all());

    return redirect()->route('dashboard.payroll')->with('success', 'Payroll updated successfully!');
}

public function destroy($id)
{
    $payroll = Payroll::findOrFail($id);
    $payroll->delete();

    return redirect()->route('dashboard.payroll')->with('success', 'Payroll record deleted successfully!');
}

}

