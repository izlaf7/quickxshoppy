<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Add owner</title>
</head>
<body>
    <h1>Add Seller</h1>
    <form action="add_owner.php" method="POST">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name"><br><br>
        <label for="email">Whatsapp no:</label><br>
        <input type="text" id="Whatsappno" name="whatsappno"><br><br>
        <input type="submit" value="Add Owner">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $whatsappno = $_POST['whatsappno'];

        // Database connection
        $conn = new mysqli("localhost", "root", "", "quick");

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert owner into database
        $sql = "INSERT INTO owners (name, whatsappno) VALUES ('$name', '$whatsappno')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New owner added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close connection
        $conn->close();
    }
    ?>
</body>
</html>




































<?php














?>