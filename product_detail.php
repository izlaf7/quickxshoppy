<?php
if (!isset($_GET['id'])) {
    echo "Product ID is missing.";
    exit;
}

$conn = new mysqli("localhost", "root", "", "quick");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$productId = $conn->real_escape_string($_GET['id']);
$query = "SELECT p.id, p.name, p.price, p.description, p.image, o.name AS seller_name, o.whatsappno, p.delivery_days 
          FROM products p 
          JOIN owners o ON p.owner_id = o.id 
          WHERE p.id = $productId";

$result = $conn->query($query);
if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    echo "Product not found.";
    exit;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['name']; ?> - Product Details</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Carousel Styling */
        
    </style>
</head>
<body>
<span class="close" onclick="closeModal()">&times;</span>
    <div class="product-detail">
        <h1><?php echo $product['name']; ?></h1>

        <!-- Image Carousel -->
        <div class="carousel">
            <div class="carousel-images" id="carouselImages">
                <?php
                $images = explode(",", $product['image']);
                foreach ($images as $img) {
                    echo "<img src='$img' alt='{$product['name']}'>";
                }
                ?>
            </div>
            <div class="carousel-buttons">
                <button onclick="changeSlide(-1)">&#10094;</button>
                <button onclick="changeSlide(1)">&#10095;</button>
            </div>
        </div>

        <p><strong>Price:</strong> $<?php echo $product['price']; ?></p>
        <p><strong>Description:</strong> <?php echo $product['description']; ?></p>
        <p><strong>Seller:</strong> <?php echo $product['seller_name']; ?></p>
        <p><strong>WhatsApp:</strong> <?php echo $product['whatsappno']; ?></p>
        <p><strong>Delivery Days:</strong> <?php echo $product['delivery_days']; ?></p>
        <a href="https://wa.me/<?php echo $product['whatsappno']; ?>?text=Hello, I want to buy <?php echo $product['name']; ?> (Price: $<?php echo $product['price']; ?>)" target="_blank" class="btn">Place Order</a>
    </div>

    <script>
        let currentSlide = 0;

        function changeSlide(direction) {
            const carouselImages = document.getElementById('carouselImages');
            const images = carouselImages.children;
            const totalImages = images.length;

            currentSlide = (currentSlide + direction + totalImages) % totalImages;
            const offset = -currentSlide * 100; // Move by 100% for each slide
            carouselImages.style.transform = `translateX(${offset}%)`;
        }

        
    </script>
</body>
</html>