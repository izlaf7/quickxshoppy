<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quickxshoppy</title>
    <link rel="stylesheet" href="style.css">
    <script>
        let currentSlideIndex = 0;
        let images = [];

        function showProductDetails(product) {
            console.log("Product data received:", product); // Debugging
            document.getElementById('productModal').style.display = 'block';
            document.getElementById('modalTitle').innerText = product.name;
            document.getElementById('modalPrice').innerText = "Price: $" + product.price;
            document.getElementById('modalDescription').innerText = product.description;
            document.getElementById('modalSeller').innerText = "Seller: " + product.seller_name;
            document.getElementById('modalWhatsapp').innerText = "WhatsApp: " + product.whatsappno;
            document.getElementById('modalDelivery').innerText = "Delivery Days: " + product.delivery_days;

            // Set up the slider images
            images = product.image.split(',');
            currentSlideIndex = 0;
            updateSliderImage();

            document.getElementById('addToCartBtn').onclick = function() {
                const quantity = document.getElementById('quantity').value;
                const whatsappLink = `https://wa.me/${product.whatsappno}?text=Hello, I want to buy ${product.name} (Price: $${product.price}) in quantity: ${quantity}`;
                window.open(whatsappLink, '_blank');
            };
        }

        function updateSliderImage() {
            if (images.length > 0) {
                document.getElementById('sliderImage').src = images[currentSlideIndex];
            }
        }

        function changeSlide(direction) {
            currentSlideIndex = (currentSlideIndex + direction + images.length) % images.length;
            updateSliderImage();
        }

        function closeModal() {
            document.getElementById('productModal').style.display = 'none';
        }
    </script>
</head>
<body>
    <header>
    
        Quickxshoppy

        
    </header>
    <div class="gap"></div>
    
        
    <div class="navbar">
        <a href="index.php" class="btn">Home</a>
        
        <a href="https://wa.me/94701459610" target="_blank" class="btn">Contact us</a>
        
    <a href="add_owner.php" class="btn">Add owner</a>
    <a href="add_product.php" class="btn">Add product</a>
    </d>
    <!-- Category Buttons -->
    <div class="categories">
        <form method="GET" action="index.php">
            <button type="submit" name="category" value="all">All</button>
            <?php
            $conn = new mysqli("localhost", "root", "", "quick");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $result = $conn->query("SELECT DISTINCT category FROM products");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<button type='submit' name='category' value='" . $row['category'] . "'>" . $row['category'] . "</button>";
                }
            }
            $conn->close();
            ?>
        </form>
    </div>

    <!-- Search Bar -->
    <div class="search-bar">
        <form method="GET" action="index.php">
            <input type="text" name="search" placeholder="Search products..." required>
            <button type="submit">Search</button>
        </form>
    </div>

    <div class="product-list">
        <?php
        $conn = new mysqli("localhost", "root", "", "quick");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Filter by category or search
        $categoryFilter = isset($_GET['category']) && $_GET['category'] !== 'all' ? "WHERE p.category = '" . $conn->real_escape_string($_GET['category']) . "'" : "";
        $searchFilter = isset($_GET['search']) ? "WHERE p.name LIKE '%" . $conn->real_escape_string($_GET['search']) . "%'" : "";

        // Query to fetch products with the latest ones on top
        $query = "SELECT p.id, p.name, p.price, p.description, p.image, o.name AS seller_name, o.whatsappno, p.delivery_days 
                  FROM products p 
                  JOIN owners o ON p.owner_id = o.id 
                  $categoryFilter $searchFilter
                  ORDER BY p.id DESC"; // Order by ID in descending order

        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $images = explode(",", $row['image']);
                $image = $images[0]; // Display the first image
                echo "
                <div class='product'>
                    <a href='product_detail.php?id={$row['id']}'>
                        <img src='$image' alt='{$row['name']}' class='product-image'>
                    </a>
                    <h3>{$row['name']}</h3>
                    <p>Price: $ {$row['price']}</p>
                    <a href='product_detail.php?id={$row['id']}' class='btn'>Product Details</a>
                </div>";
            }
        } else {
            echo "<p>No products available.</p>";
        }
        $conn->close();
        ?>
    </div>

    <!-- Product Details Modal -->
    <div id="productModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle"></h2>

            <!-- Image Slider -->
            <div class="slider">
                <img id="sliderImage" src="" alt="Product Image" class="modal-image">
                <button class="prev" onclick="changeSlide(-1)">&#10094;</button>
                <button class="next" onclick="changeSlide(1)">&#10095;</button>
            </div>

            <p id="modalPrice"></p>
            <p id="modalDescription"></p>
            <p id="modalSeller"></p>
            <p id="modalWhatsapp"></p>
            <p id="modalDelivery"></p>
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" value="1" min="1">
            <button id="addToCartBtn">Add to Cart</button>
        </div>
    </div>
</body>
</html>

