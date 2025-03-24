<!DOCTYPE html>
<html>
<head>
    <title>Project Xovis - Upload CSV</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 500px;
            margin: 60px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.08);
            text-align: center;
        }
        h2 {
            color: #333;
        }
        input[type="file"],
        input[type="submit"] {
            margin: 10px 0;
            padding: 10px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        hr {
            margin: 30px 0;
        }
        .danger {
            background-color: #dc3545;
        }
        .danger:hover {
            background-color: #a71d2a;
        }
        small {
            color: #666;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 6px;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📤 Upload People Flow CSV File</h2>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="csv_file" accept=".csv" required>
            <input type="submit" name="submit" value="Upload and Import">
        </form>
        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            <div class="success-message">✅ CSV data imported successfully!</div>
        <?php endif; ?>
        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
            <div class="success-message">
                ✅ CSV data imported successfully!
                <br><br>
                <!--<a href="dashboard.php" class="dashboard-btn">📊 View Dashboard</a>-->
            </div>
        <?php endif; ?>
        <a href="dashboard.php" class="dashboard-btn">📊 View Dashboard</a>
        <hr>

        <h3>⚠️ Clear Old Record</h3>
        <form action="clear.php" method="post" onsubmit="return confirm('Are you sure you want to delete all records?');">
            <input type="submit" name="clear" value="Clear Database" class="danger">
        </form>
        <br>
        <small>All data will be permanently deleted.</small>
    </div>
</body>

</html>
