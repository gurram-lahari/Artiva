<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Search Results</title>
</head>
<body>
    <div class="container mt-4">
        <h2>Search Results</h2>
        <?php
        if (isset($_GET['q']) && !empty($_GET['q'])) {
            $query = $_GET['q'];

            // Database connection
            $servername = "localhost";
            $username = "root"; // Update if needed
            $password = "";     // Update if needed
            $dbname = "artiva";

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM product WHERE productname LIKE ? OR description LIKE ?";
            $stmt = $conn->prepare($sql);
            $searchTerm = "%" . $query . "%";
            $stmt->bind_param('ss', $searchTerm, $searchTerm);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='result-item mb-3'>";
                    echo "<h5>" . htmlspecialchars($row['productname']) . "</h5>";
                    echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                    echo "<p><b>Price:</b> $" . htmlspecialchars($row['price']) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No results found.</p>";
            }

            $stmt->close();
            $conn->close();
        } else {
            echo "<p>Please enter a search term.</p>";
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
