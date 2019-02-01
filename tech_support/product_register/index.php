<?php

require('../model/database.php');
require('../model/customer_db.php');
require('../model/product_db.php');
require('../model/registration_db.php');



session_start();

if (isSet($_POST['action'])) {
    $action = $_POST['action'];
} else if (isSet($_GET['action'])) {
    $action = $_GET['action'];
} else if (isSet($_SESSION['email'])) {
    $action = 'get_customer';
} else {
    $action = 'login_customer';
}

//$action = filter_input(INPUT_POST, 'action');
//if ($action === NULL) {
//    $action = filter_input(INPUT_GET, 'action');
//    if ($action === NULL) {
//        $action = 'login_customer';
//    }
//}
//instantiate variable(s)
//$email = '';

if ($action == 'login_customer') {
    include('customer_login.php');
} else if ($action == 'get_customer') {
    if (!isSet($_SESSION['email'])) {
        $_SESSION['email'] = $_POST['email'];
    }
    //$email = filter_input(INPUT_POST, 'email');
    $customer = get_customer_by_email($_SESSION['email']);
    $products = get_products();
    include('product_register.php');
} else if ($action == 'register_product') {
    if (!isSet($_SESSION['customerID'])) {
        $_SESSION['customerID'] = $_POST['customerID'];
    }
    //$customer_id = filter_input(INPUT_POST, 'customer_id', FILTER_VALIDATE_INT);
    $product_code = filter_input(INPUT_POST, 'product_code');
    add_registration($_SESSION['customerID'], $product_code, $date);
    $message = "Product ($product_code) was registered successfully.";
    include('product_register.php');
} else if ($action = 'logout_customer') {
    session_destroy();
    include('customer_login.php');
}
?>