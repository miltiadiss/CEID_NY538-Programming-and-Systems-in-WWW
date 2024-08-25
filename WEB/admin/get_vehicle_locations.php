<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized access']);
    exit;
}

$conn = new mysqli("localhost", "root", "", "web");

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

$sql = "SELECT v.vehicle AS vehicle_id, v.latitude_vehicle, v.longtitude_vehicle 
        FROM VOLUNTEER v";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $vehicles = [];
    while ($row = $result->fetch_assoc()) {
        $vehicles[] = $row;
    }
    echo json_encode([
        'success' => true,
        'vehicles' => $vehicles
    ]);
} else {
    echo json_encode(['success' => false, 'error' => 'No vehicles found']);
}

$conn->close();
?>