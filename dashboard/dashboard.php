<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "xovis_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$today = date("Y-m-d");

// Total people entered today
$sql = "SELECT COUNT(*) AS total_today FROM people_flow WHERE DATE(entry_time) = '$today'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$totalToday = $row['total_today'];

// Entries per minute
$timeData = [];
$sql = "SELECT DATE_FORMAT(entry_time, '%H:%i') AS minute, COUNT(*) AS count 
        FROM people_flow 
        WHERE DATE(entry_time) = '$today' 
        GROUP BY minute";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $timeData[$row['minute']] = $row['count'];
}

$labels = array_keys($timeData);
$data = array_values($timeData);




// People type breakdown
$visitorCount = 0;
$employeeCount = 0;

$sql = "SELECT person_type, COUNT(*) AS total 
        FROM people_flow 
        WHERE DATE(entry_time) = '$today' 
        GROUP BY person_type";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    if (strtolower($row['person_type']) === "employee") {
        $employeeCount = $row['total'];
    } elseif (strtolower($row['person_type']) === "visitor") {
        $visitorCount = $row['total'];
    }
}





// DAILY REPORT
$dailyReport = [];

$sql = "SELECT 
            DATE(entry_time) AS entry_date,
            SUM(CASE WHEN person_type = 'employee' THEN 1 ELSE 0 END) AS employees,
            SUM(CASE WHEN person_type = 'visitor' THEN 1 ELSE 0 END) AS visitors,
            COUNT(*) AS total
        FROM people_flow
        GROUP BY entry_date
        ORDER BY entry_date DESC";

$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $dailyReport[] = $row;
}




?>

<!DOCTYPE html>
<html>
<head>
    <title>Project Xovis – Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f8fc;
            margin: 0;
            padding: 30px;
            text-align: center;
        }
        h2 {
            color: #111;
        }
        .counter {
            font-size: 60px;
            color: navy;
            margin-bottom: 40px;
        }
        canvas {
            max-width: 800px;
            margin: auto;
        }


        .download-btn {
            position: absolute;
            top: 30px;
            right: 30px;
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }

        .download-btn:hover {
            background-color: #218838;
        }



        .report-table {
            width: 80%;
            margin: 30px auto;
            border-collapse: collapse;
            font-size: 16px;
        }

        .report-table th, .report-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        .report-table th {
            background-color: #007bff;
            color: white;
        }

        .report-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            position: absolute;
            top: 30px;
            left: 30px;
        }

        .back-btn:hover {
            background-color: #5a6268;
        }


    </style>
</head>
<body>

    <a href="index.php" class="back-btn">⬅️ Back to Upload</a>

    <a href="#" onclick="downloadPDF()" class="download-btn">📄 Download PDF Report</a>


    <div id="reportContent">
        
        <h2>Total People Entered Today</h2>
        <div class="counter"><?= $totalToday ?></div>

        <h2>Peak Time Graph (Entries per Minute)</h2>
        <canvas id="peakChart" height="100"></canvas>

        <script>
            const ctx = document.getElementById('peakChart').getContext('2d');
            const peakChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?= json_encode($labels); ?>,
                    datasets: [{
                        label: 'Entries per Minute',
                        data: <?= json_encode($data); ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        </script>


        <h2>People Type Breakdown (Pie Chart)</h2>
        <canvas id="pieChart" height="100"></canvas>

        <script>
            const pieCtx = document.getElementById('pieChart').getContext('2d');
            const pieChart = new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: ['Employees', 'Visitors'],
                    datasets: [{
                        data: [<?= $employeeCount ?>, <?= $visitorCount ?>],
                        backgroundColor: ['#007bff', '#28a745'],
                        borderColor: ['#0056b3', '#1e7e34'],
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        </script>

        <h2>Daily Traffic Report</h2>
        <table class="report-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Total Entries</th>
                    <th>Employees</th>
                    <th>Visitors</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dailyReport as $row): ?>
                    <tr>
                        <td><?= $row['entry_date'] ?></td>
                        <td><?= $row['total'] ?></td>
                        <td><?= $row['employees'] ?></td>
                        <td><?= $row['visitors'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

    



    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function downloadPDF() {
            const element = document.getElementById('reportContent');
            const opt = {
                margin:       0.5,
                filename:     'xovis_report_<?= date("Y-m-d") ?>.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            html2pdf().set(opt).from(element).save();
        }
    </script>



</body>
</html>
