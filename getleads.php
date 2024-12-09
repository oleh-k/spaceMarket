<?php
require 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get Leads</title>
</head>
<body>
    <h1>Get Leads</h1>

    <form method="get">
        <label for="date_from">From:</label>
        <input type="date" name="date_from" required>

        <label for="date_to">To:</label>
        <input type="date" name="date_to" required>

        <label for="status">Status:</label>
        <select name="status">
            <option value="all">All</option>
            <option value="success">Success</option>
            <option value="failed">Failed</option>
            <option value="pending">Pending</option>
        </select>

        <button type="submit">Filter</button>
    </form>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Country Code</th>
                <th>Offer ID</th>
                <th>Box ID</th>
                <th>IP Address</th>
                <th>Landing URL</th>
                <th>Password</th>
                <th>Language</th>
                <th>Click ID</th>
                <th>Quiz Answers</th>
                <th>Custom Field 1</th>
                <th>Custom Field 2</th>
                <th>Custom Field 3</th>
                <th>Status</th>
                <th>Created At</th>
                <th>autologin</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (isset($_GET['date_from']) && isset($_GET['date_to'])) {
            $statusFilter = ($_GET['status'] !== 'all') ? "AND status = :status" : "";

            $query = "SELECT * FROM leads 
                      WHERE DATE(created_at) BETWEEN :date_from AND :date_to 
                      $statusFilter 
                      ORDER BY created_at DESC";

            $stmt = $pdo->prepare($query);
            $params = [
                'date_from' => $_GET['date_from'],
                'date_to' => $_GET['date_to']
            ];

            if ($_GET['status'] !== 'all') {
                $params['status'] = $_GET['status'];
            }

            $stmt->execute($params);

            $leads = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($leads) {
                foreach ($leads as $lead) {
                    echo "<tr>
                            <td>{$lead['id']}</td>
                            <td>{$lead['firstName']}</td>
                            <td>{$lead['lastName']}</td>
                            <td>{$lead['email']}</td>
                            <td>{$lead['phone']}</td>
                            <td>{$lead['countryCode']}</td>
                            <td>{$lead['offer_id']}</td>
                            <td>{$lead['box_id']}</td>
                            <td>{$lead['ip_address']}</td>
                            <td>{$lead['landingUrl']}</td>
                            <td>{$lead['password']}</td>
                            <td>{$lead['language']}</td>
                            <td>{$lead['clickId']}</td>
                            <td>{$lead['quizAnswers']}</td>
                            <td>{$lead['custom1']}</td>
                            <td>{$lead['custom2']}</td>
                            <td>{$lead['custom3']}</td>
                            <td>{$lead['status']}</td>
                            <td>{$lead['created_at']}</td>
                            <td>{$lead['autologin']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='19'>No leads found</td></tr>";
            }
        }
        ?>
        </tbody>
    </table>

    <a href="index.php">Back to Form</a>
    <a href="getstatuses.php">View statuses</a>
</body>
</html>