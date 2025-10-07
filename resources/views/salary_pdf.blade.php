@php
    $totalOT = 0;
    $totalAdvance = 0;
    $totalNetSalary = 0;
@endphp

<h2 style="text-align: right; margin-bottom: 20px; margin-left: 8px;">
    Salary Sheet - {{ \Carbon\Carbon::parse($selectedMonth)->format('F Y') }}
</h2>


<table border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse; width: 100%;">
    <tbody>
        <tr style="background-color:#f0f0f0; font-weight:bold;">
            <th>ID</th>
            <th>Employee Name</th>
            <th>EPF No</th>
            <th>Basic</th>
            <th>Budget</th>
            <th>Gross Salary</th>
            <th>Transport</th>
            <th>Attendance</th>
            <th>Phone</th>
            <th>Production</th>
            <th>Car</th>
            <th>Loan</th>
            <th>OT</th>
            <th>Total Earnings</th>
            <th>EPF (8%)</th>
            <th>EPF (12%)</th>
            <th>ETF (3%)</th>
            <th>Advance</th>
            <th>Stamp Duty</th>
            <th>No Pay</th>
            <th>Total Deductions</th>
            <th>Net Salary</th>
        </tr>
    <tbody>
        @foreach($employees as $record)
        @php
            $totalOT += $record->ot_payment ?? 0;
            $totalAdvance += $record->advance_payment ?? 0;
            $totalNetSalary += $record->net_salary ?? 0;
        @endphp
        <tr>
            <td>{{ $record->employee_id ?? 0}}</td>
            <td>{{ $record->employee_name  ?? '' }}</td>
            <td>{{ $record->epf_no ?? '' }}</td>
            <td>{{ $record->basic ?? 0.00 }}</td>
            <td>{{ $record->budget_allowance ?? 0.00 }}</td>
            <td>{{ $record->gross_salary ?? 0.00 }}</td>
            <td>{{ $record->transport_allowance ?? 0.00 }}</td>
            <td>{{ $record->attendance_allowance ?? 0.00 }}</td>
            <td>{{ $record->phone_allowance ?? 0.00 }}</td>
            <td>{{ $record->production_bonus ?? 0.00 }}</td>
            <td>{{ $record->car_allowance  ?? 0.00 }}</td>
            <td>{{ $record->loan_payment ?? 0.00 }}</td>
            <td>{{ number_format($record->ot_payment ?? 0, 1) }}</td>
            <td>{{ number_format($record->total_earnings ?? 0, 1) }}</td>
            <td>{{ number_format($record->epf_8_percent ?? 0, 1) }}</td>
            <td>{{ number_format($record->epf_12_percent ?? 0, 1) }}</td>
            <td>{{ number_format($record->etf_3_percent ?? 0, 1) }}</td>
            <td>{{ number_format($record->advance_payment ?? 0, 1) }}</td>
            <td>{{ number_format($record->stamp_duty ?? 0, 1) }}</td>
            <td>{{ number_format($record->no_pay ?? 0, 1) }}</td>
            <td>{{ number_format($record->total_deductions ?? 0, 1) }}</td>
            <td>{{ number_format($record->net_salary ?? 0, 1) }}</td>
        </tr>
        @endforeach
        <!-- Totals row -->
       <tr class="font-bold bg-gray-100 border-0">
    <td colspan="12" class="text-center border-0"></td>
    <td class="border-0">{{ number_format($totalOT, 2) }}</td>
    <td class="border-0"></td>
    <td class="border-0"></td>
    <td class="border-0"></td>
    <td class="border-0 mr-4"></td>
    <td class="border-0">{{ number_format($totalAdvance, 2) }}</td>
    <td class="border-0"></td>
    <td class="border-0"></td>
    <td class="border-0"></td>
    <td class="border-0">{{ number_format($totalNetSalary, 2) }}</td>
</tr>

    </tbody>
</table>
