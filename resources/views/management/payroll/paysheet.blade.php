<!DOCTYPE html>
<html>
<head>
    <title>Payslip</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        .payslip-container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            text-align: center;
            margin: 0;
            color: #333;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        h2 {
            font-size: 18px;
            margin-bottom: 20px;
            color: #555;
        }
        .details-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .details-section div {
            flex: 1;
        }
        .details-section div p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }
        .details-section div p span {
            font-weight: bold;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-size: 14px;
        }
        th {
            background-color: #f4f4f4;
            color: #333;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .totals-row {
            background-color: #f9f9f9;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="payslip-container">
        <h1>Payslip</h1>
        <h2>Month: {{ $record->payed_month }}</h2>

        <div class="details-section">
            <div>
                <p><span>Employee Name:</span> {{ $record->employee_name }}</p>
                <p><span>Employee ID:</span> {{ $record->employee_id }}</p>
            </div>
            <div>
                <p><span>Department:</span> {{ $record->department }}</p>
                <p><span>Pay Date:</span> {{ $record->pay_date }}</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="text-right">Earnings</th>
                    <th class="text-right">Deductions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Basic Salary</td>
                    <td class="text-right">{{ number_format($record->basic, 2) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Budget Allowance</td>
                    <td class="text-right">{{ number_format($record->budget_allowance, 2) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Gross Salary</td>
                    <td class="text-right">{{ number_format($record->gross_salary, 2) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Transport Allowance</td>
                    <td class="text-right">{{ number_format($record->transport_allowance, 2) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Attendance Allowance</td>
                    <td class="text-right">{{ number_format($record->attendance_allowance, 2) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Phone Allowance</td>
                    <td class="text-right">{{ number_format($record->phone_allowance, 2) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Production Bonus</td>
                    <td class="text-right">{{ number_format($record->production_bonus, 2) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Car Allowance</td>
                    <td class="text-right">{{ number_format($record->car_allowance, 2) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>EPF (12%)</td>
                    <td></td>
                    <td class="text-right">{{ number_format($record->epf_12_percent, 2) }}</td>
                </tr>
                <tr>
                    <td>ETF (3%)</td>
                    <td></td>
                    <td class="text-right">{{ number_format($record->etf_3_percent, 2) }}</td>
                </tr>
                <tr>
                    <td>Advance Payment</td>
                    <td></td>
                    <td class="text-right">{{ number_format($record->advance_payment, 2) }}</td>
                </tr>
                <tr>
                    <td>Loan Payment</td>
                    <td></td>
                    <td class="text-right">{{ number_format($record->loan_payment, 2) }}</td>
                </tr>
                <tr class="totals-row">
                    <td>Total Earnings</td>
                    <td class="text-right">{{ number_format($record->total_earnings, 2) }}</td>
                    <td></td>
                </tr>
                <tr class="totals-row">
                    <td>Total Deductions</td>
                    <td></td>
                    <td class="text-right">{{ number_format($record->total_deductions, 2) }}</td>
                </tr>
                <tr class="totals-row">
                    <td>Net Salary</td>
                    <td class="text-right">{{ number_format($record->net_salary, 2) }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <p>This is a computer-generated payslip. If you have any queries, contact HR.</p>
        </div>
    </div>
</body>
</html>
