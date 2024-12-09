<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lead Statuses</title>
</head>
<body>
    <h1>Lead Statuses</h1>

    <form method="get">
        <label for="date_from">From:</label>
        <input type="date" name="date_from" required>
        <label for="date_to">To:</label>
        <input type="date" name="date_to" required>
        <button type="submit">Filter</button>
    </form>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Status</th>
            <th>FTD</th>
        </tr>

        <?php
        if (isset($_GET['date_from']) && isset($_GET['date_to'])) {
            $data = [
                "date_from" => $_GET['date_from'] . " 00:00:00",
                "date_to" => $_GET['date_to'] . " 23:59:59",
                "page" => 0,
                "limit" => 100
            ];

            $ch = curl_init('https://crm.belmar.pro/api/v1/getstatuses');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'token: ba67df6a-a17c-476f-8e95-bcdb75ed3958'
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            curl_close($ch);

            $leads = json_decode($response, true);
            if (isset($leads['data'])) {
                foreach ($leads['data'] as $lead) {
                    echo "<tr>
                            <td>{$lead['id']}</td>
                            <td>{$lead['email']}</td>
                            <td>{$lead['status']}</td>
                            <td>{$lead['ftd']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No leads found</td></tr>";
            }
        }
        ?>
    </table>
    <a href="index.php">Back to Form</a>
    <a href="getleads.php">View Leads</a>

</body>
</html>