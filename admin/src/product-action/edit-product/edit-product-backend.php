<?php
    session_start();
    require('../../database/database.php');

    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $productPrice = $_POST['product_price'];
    $productQuantity = $_POST['product_quantity'];

    $db = Database::getInstance();

    // if($db->editProduct($productId, $productName, $productPrice, $productQuantity)){
    //     $_SESSION['eidt_success_message'] = "Product edited";
    //     header("Location: ../../products/products.php");
    //     exit();
    // }
    // ;
?>