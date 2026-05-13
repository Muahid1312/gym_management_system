<!DOCTYPE html>
<html>
<head>
    <title>Gym Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <h1>Gym Report</h1>
    <p>Daily Income: AF {{ number_format($dailyIncome, 2) }}</p>
    <p>Monthly Income: AF {{ number_format($monthlyIncome, 2) }}</p>
    <p>Active Members: {{ $activeMembers }}</p>
    <p>Expired Members: {{ $expiredMembers }}</p>
    <h2>Members with Debt</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Debt</th>
            </tr>
        </thead>
        <tbody>
            @foreach($membersWithDebt as $member)
                <tr>
                    <td>{{ $member['name'] }}</td>
                    <td>AF {{ number_format($member['debt'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>