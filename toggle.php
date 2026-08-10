<?php
require_once "db.php";

header("Content-Type: application/json");

if (!isset($_POST["id"])) {
    echo json_encode([
        "success" => false,
        "message" => "ID is required"
    ]);
    exit;
}

$id = (int) $_POST["id"];

// Toggle status between 0 and 1
$stmt = $conn->prepare(
    "UPDATE users 
     SET status = IF(status = 0, 1, 0) 
     WHERE id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

// Get the updated status
$stmt2 = $conn->prepare(
    "SELECT status FROM users WHERE id = ?"
);

$stmt2->bind_param("i", $id);
$stmt2->execute();

$result = $stmt2->get_result();
$row = $result->fetch_assoc();

if ($row) {
    echo json_encode([
        "success" => true,
        "new_status" => (int) $row["status"]
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "User not found"
    ]);
}

$stmt->close();
$stmt2->close();
$conn->close();
?>