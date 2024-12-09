<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        "firstName" => $_POST['firstName'],
        "lastName" => $_POST['lastName'],
        "phone" => $_POST['phone'],
        "email" => $_POST['email'],
        "countryCode" => $_POST['countryCode'],
        "offer_id" => (int)$_POST['offer_id'],
        "box_id" => (int)$_POST['box_id'],
        "ip_address" => $_POST['ip'],
        "landingUrl" => $_POST['landingUrl'],
        "password" => $_POST['password'] ?? "qwerty12",
        "language" => $_POST['language'] ?? "en",
        "clickId" => $_POST['clickId'] ?? null,
        "quizAnswers" => $_POST['quizAnswers'] ?? null,
        "custom1" => $_POST['custom1'] ?? null,
        "custom2" => $_POST['custom2'] ?? null,
        "custom3" => $_POST['custom3'] ?? null,
        "status" => 'pending'
    ];

    $stmt = $pdo->prepare("INSERT INTO leads 
        (firstName, lastName, phone, email, countryCode, offer_id, box_id, ip_address, landingUrl, password, language, clickId, quizAnswers, custom1, custom2, custom3, status) 
        VALUES 
        (:firstName, :lastName, :phone, :email, :countryCode, :offer_id, :box_id, :ip_address, :landingUrl, :password, :language, :clickId, :quizAnswers, :custom1, :custom2, :custom3, :status)");

    try {
        $stmt->execute($data);
        $leadId = $pdo->lastInsertId();
    } catch (PDOException $e) {
        die("Database Error: " . $e->getMessage());
    }

    $ch = curl_init('https://crm.belmar.pro/api/v1/addlead');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'token: ba67df6a-a17c-476f-8e95-bcdb75ed3958'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $apiResponse = json_decode($response, true);
    curl_close($ch);

    $status = isset($apiResponse['status']) && $apiResponse['status'] == 1 ? 'success' : 'failed';
    $autologin = $apiResponse['autologin'] ?? null;

    $updateStmt = $pdo->prepare("UPDATE leads SET status = :status, autologin = :autologin WHERE id = :id");
    $updateStmt->execute([
        'status' => $status,
        'autologin' => $autologin,
        'id' => $leadId
    ]);

    echo "<h1>Response</h1>";
    echo "<pre>" . print_r($apiResponse, true) . "</pre>";
    echo '<a href="index.php">Back to Form</a>';
}
?>