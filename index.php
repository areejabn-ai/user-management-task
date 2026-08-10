<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once "db.php";

// Add new user
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $age = (int) ($_POST["age"] ?? 0);

    if ($name !== "" && $age > 0) {

        $stmt = $conn->prepare(
            "INSERT INTO users (name, age, status) VALUES (?, ?, 0)"
        );

        $stmt->bind_param("si", $name, $age);
        $stmt->execute();
        $stmt->close();

        header("Location: index.php");
        exit;
    }
}

// Get users
$result = $conn->query(
    "SELECT id, name, age, status FROM users ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User Management System</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f5f5f5;
            margin: 0;
            padding: 40px;
        }

        h1 {
            margin-bottom: 30px;
        }

        .form-container {
            background: white;
            display: inline-block;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        input {
            padding: 10px;
            margin: 5px;
        }

        input[type="submit"] {
            cursor: pointer;
            padding: 10px 20px;
        }

        table {
            width: 70%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 12px;
        }

        th {
            background-color: #eee;
        }

        button {
            cursor: pointer;
            padding: 7px 15px;
        }
    </style>
</head>

<body>

    <h1>User Management System</h1>

    <div class="form-container">

        <form method="POST" action="index.php">

            <label>Name:</label>

            <input
                type="text"
                name="name"
                required
            >

            <label>Age:</label>

            <input
                type="number"
                name="age"
                min="1"
                required
            >

            <input
                type="submit"
                value="Submit"
            >

        </form>

    </div>

    <table>

        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

            <?php
            if ($result && $result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {

                    $id = (int) $row["id"];
                    $name = htmlspecialchars($row["name"], ENT_QUOTES, "UTF-8");
                    $age = (int) $row["age"];
                    $status = (int) $row["status"];

                    echo "
                    <tr>
                        <td>{$id}</td>
                        <td>{$name}</td>
                        <td>{$age}</td>
                        <td id='status-{$id}'>{$status}</td>
                        <td>
                            <button type='button' onclick='toggleStatus({$id})'>
                                Toggle
                            </button>
                        </td>
                    </tr>
                    ";
                }

            } else {

                echo "
                <tr>
                    <td colspan='5'>No records found.</td>
                </tr>
                ";
            }
            ?>

        </tbody>

    </table>

    <script>
        function toggleStatus(id) {

            const formData = new FormData();
            formData.append("id", id);

            fetch("toggle.php", {
                method: "POST",
                body: formData
            })

            .then(response => response.json())

            .then(data => {

                if (data.success) {

                    document.getElementById(
                        "status-" + id
                    ).innerText = data.new_status;

                } else {

                    alert("Error updating status");

                }

            })

            .catch(error => {

                console.error("Error:", error);
                alert("Something went wrong");

            });
        }
    </script>

</body>

</html>
