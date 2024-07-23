<?php
// Include necessary files or configurations
include_once('config.php'); // Include database connection or other configurations

// Check if it's an AJAX request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    // Check if the action parameter is set
    if (isset($_GET['action'])) {
        // Handle different actions
        $action = $_GET['action'];

        if ($action === 'get_products') {
            // Call the getProducts function to fetch products
            getProducts();
        }
        // Add more actions as needed
    }
}

// Define the getProducts function
function getProducts()
{
    global $db; // Assuming $db is the database connection variable

    // Your existing code to fetch products goes here
    // For example:
    $get_products_query = "SELECT * FROM products";
    $result = mysqli_query($db, $get_products_query);

    // Process the fetched products (convert to JSON or HTML as needed)
    $products = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }

    // Return the products as JSON
    echo json_encode($products);
    exit; // Terminate script after sending response
}
