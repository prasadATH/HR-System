<?php
namespace App\Http\Controllers;

use App\Models\SalaryDetails;
use App\Models\Payroll;
use Illuminate\Http\Request;
use ZipArchive;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Barryvdh\DomPDF\Facade\Pdf;

class PayrollExportController extends Controller
{
    public function downloadPaysheets(Request $request)
    {

        $selectedMonth = $request->query('selected_month'); // Get the month from the query
        if (!$selectedMonth) {
            return back()->with('error', 'Please select a valid month.');
        }

        $employees = SalaryDetails::where('payed_month', $selectedMonth)->with('employee')->get();

        if ($employees->isEmpty()) {
            return back()->with('error', 'No records found for the selected month.');
        }

        $zipFileName = "employee_paysheets_{$selectedMonth}.zip";
        $zip = new ZipArchive;

        if ($zip->open(public_path($zipFileName), ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            foreach ($employees as $employee) {
                $fileName = "paysheet_{$employee->employee_id}.pdf";
                $pdf = Pdf::loadView('management.payroll.paysheet', ['record' => $employee]);
                $zip->addFromString($fileName, $pdf->output());
            }
            $zip->close();

            return response()->download(public_path($zipFileName))->deleteFileAfterSend(true);
        }

        return back()->with('error', 'Failed to create zip file.');
    }

    public function generatePreviousMonth(Request $request)
{
    $selectedMonth = $request->query('selected_month');
    $previousMonth = date('Y-m', strtotime('-1 month', strtotime($selectedMonth)));

    $payrolls = SalaryDetails::where('payed_month', $previousMonth)->get();

    foreach ($payrolls as $payroll) {
        SalaryDetails::create([
            'employee_name' => $payroll->employee_name,
            'employee_id' => $payroll->employee_id,
            'known_name' => $payroll->known_name,
            'epf_no' => $payroll->epf_no,
            'basic' => $payroll->basic,
            'budget_allowance' => $payroll->budget_allowance,
            'gross_salary' => $payroll->gross_salary,
            'transport_allowance' => $payroll->transport_allowance,
            'attendance_allowance' => $payroll->attendance_allowance,
            'phone_allowance' => $payroll->phone_allowance,
            'production_bonus' => $payroll->production_bonus,
            'car_allowance' => $payroll->car_allowance,
            'loan_payment' => $payroll->loan_payment,
            'total_earnings' => $payroll->total_earnings,
            'epf_8_percent' => $payroll->epf_8_percent,
            'epf_12_percent' => $payroll->epf_12_percent,
            'etf_3_percent' => $payroll->etf_3_percent,
            'advance_payment' => $payroll->advance_payment,
            'stamp_duty' => $payroll->stamp_duty,
            'no_pay' => $payroll->no_pay,
            'total_deductions' => $payroll->total_deductions,
            'net_salary' => $payroll->net_salary,
            'loan_balance' => $payroll->loan_balance,
            'pay_date' => now(),
            'payed_month' => $selectedMonth,
            'status' => $payroll->status,
        ]);
    }

    return redirect()->route('payroll.index')->with('success', 'Records generated for the selected month.');
}

    public function exportSalarySpreadsheet(Request $request)
    {//dd($request->all());
        $selectedMonth = $request->query('selected_month'); // Get the month from the query
        if (!$selectedMonth) {
            return back()->with('error', 'Please select a valid month.');
        }
       // dd($selectedMonth);
        $employees = SalaryDetails::where('payed_month', $selectedMonth)->get();
      //  dd($employees);
        if ($employees->isEmpty()) {

            return back()->with('error', 'No records found for the selected month.');
        }

        $filePath = storage_path("app/public/employee_salaries_{$selectedMonth}.xlsx");
        $writer = SimpleExcelWriter::create($filePath);

        // Add column headings
        $writer->addHeader([
            'Employee ID', 'Employee Name', 'Known Name', 'EPF No', 'Basic Salary',
            'Budget Allowance', 'Gross Salary', 'Transport Allowance', 'Attendance Allowance',
            'Phone Allowance', 'Production Bonus', 'Car Allowance', 'Loan Payment',
            'Total Earnings', 'EPF (8%)', 'EPF (12%)', 'ETF (3%)', 'Advance Payment',
            'Stamp Duty', 'No Pay', 'Total Deductions', 'Net Salary', 'Loan Balance',
            'Pay Date', 'Paid Month'
        ]);

        // Add rows
        foreach ($employees as $record) {
            $writer->addRow([
                $record->employee_id,
                $record->employee_name,
                $record->known_name,
                $record->epf_no,
                $record->basic,
                $record->budget_allowance,
                $record->gross_salary,
                $record->transport_allowance,
                $record->attendance_allowance,
                $record->phone_allowance,
                $record->production_bonus,
                $record->car_allowance,
                $record->loan_payment,
                $record->total_earnings,
                $record->epf_8_percent,
                $record->epf_12_percent,
                $record->etf_3_percent,
                $record->advance_payment,
                $record->stamp_duty,
                $record->no_pay,
                $record->total_deductions,
                $record->net_salary,
                $record->loan_balance,
                $record->pay_date,
                $record->payed_month,
            ]);
        }

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
