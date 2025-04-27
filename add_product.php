<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Add Product</h1>
    <form action="add_product.php" method="POST" enctype="multipart/form-data">
        <label for="name">Product Name:</label><br>
        <input type="text" id="name" name="name" required><br>
        
        <label for="price">Price:</label><br>
        <input type="text" id="price" name="price" required><br>
        
        <label for="description">Description:</label><br>
        <textarea id="description" name="description" required></textarea><br>
        
        <label for="image1">Product Image 1:</label><br>
        <input type="file" id="image1" name="image1" accept="image/*" required><br>

        <label for="image2">Product Image 2(optional):</label><br>
        <input type="file" id="image2" name="image2" accept="image/*"><br>

        <label for="image3">Product Image 3(optional):</label><br>
        <input type="file" id="image3" name="image3" accept="image/*"><br>

        <label for="catagory">Category:</label><br>
        <input type="text" id="catagory" name="catagory"><br>
        
        <label for="delivery_days">Delivery Days:</label><br>
        <input type="number" id="delivery_days" name="delivery_days" min="1" required><br>
        
        <label for="owner">Owner:</label><br>
        <select id="owner" name="owner" required>
            <?php
            // Fetch owners from the database
            $conn = new mysqli("localhost", "root", "", "quick");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $result = $conn->query("SELECT id, name FROM owners");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                }
            } else {
                echo "<option value=''>No owners available</option>";
            }
            $conn->close();
            ?>
        </select><br><br>
        
        <input type="submit" value="Add Product">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $category = $_POST['catagory'];
        $delivery_days = $_POST['delivery_days']; // Fetch the delivery days input
        $owner_id = $_POST['owner'];

        // Handle multiple image uploads
        $imageLinks = [];
        for ($i = 0; $i < 3; $i++) {
            $imageKey = "image" . ($i + 1);
            if (isset($_FILES[$imageKey]) && $_FILES[$imageKey]['error'] == 0) {
                $target_dir = "uploads/"; // Directory to save uploaded images
                $target_file = $target_dir . basename($_FILES[$imageKey]["name"]);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // Validate image file
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array($imageFileType, $allowed)) {
                    die("Error: Only JPG, JPEG, PNG, and GIF files are allowed.");
                }

                // Move the uploaded file to the target directory
                if (move_uploaded_file($_FILES[$imageKey]["tmp_name"], $target_file)) {
                    $imageLinks[] = $target_file; // Save the file path
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }

        // Save product details and links to the database
        $conn = new mysqli("localhost", "root", "", "quick");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $imageLinksString = implode(",", $imageLinks); // Store links as a comma-separated string
        $stmt = $conn->prepare("INSERT INTO products (name, price, description, image, category, delivery_days, owner_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sdsssii", $name, $price, $description, $imageLinksString, $category, $delivery_days, $owner_id);

        if ($stmt->execute()) {
            echo "New product added successfully. <br>";
            foreach ($imageLinks as $link) {
                echo "<a href='$link' target='_blank'>View Image</a><br>";
            }
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
    ?> 
</body>
</html>