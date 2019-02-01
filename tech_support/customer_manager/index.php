<?php

require('../model/database.php');
require('../model/customer_db.php');
require('../model/fields.php');
require('../model/validate.php');

$validate = new Validate();
$fields = $validate->getFields();
$fields->addField('first_name');
$fields->addField('last_name');
$fields->addField('phone', 'Use 888-555-1234 format.');
$fields->addField('email', 'Must be a valid email address.');
$fields->addField('address');
$fields->addField('city');
$fields->addField('state');
$fields->addField('zip', 'Use 5 ZIP code.');
$fields->addField('password', 'Must be at least 6 characters.');
$fields->addField('postal_code');


$action = filter_input(INPUT_POST, 'action');
if ($action === NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action === NULL) {
        $action = 'search_customers';
    }
}

//instantiate variable(s)
$last_name = '';
$customers = array();

if ($action == 'search_customers') {
    include('customer_search.php');
} else if ($action == 'display_customers') {
    $last_name = filter_input(INPUT_POST, 'last_name');
    if (empty($last_name)) {
        $message = 'You must enter a last name.';
    } else {
        $customers = get_customers_by_last_name($last_name);
    }
    include('customer_search.php');
} else if ($action == 'display_customer') {
    $customer_id = filter_input(INPUT_POST, 'customer_id', FILTER_VALIDATE_INT);
    $customer = get_customer($customer_id);
    include('customer_display.php');
} else if ($action == 'update_customer') {
    $customer_id = trim(filter_input(INPUT_POST, 'customer_id', FILTER_VALIDATE_INT));
    $first_name = trim(filter_input(INPUT_POST, 'first_name'));
    $last_name = trim(filter_input(INPUT_POST, 'last_name'));
    $address = trim(filter_input(INPUT_POST, 'address'));
    $city = trim(filter_input(INPUT_POST, 'city'));
    $state = trim(filter_input(INPUT_POST, 'state'));
    $postal_code = trim(filter_input(INPUT_POST, 'postal_code'));
    $country_code = filter_input(INPUT_POST, 'country_code');
    $phone = trim(filter_input(INPUT_POST, 'phone'));
    $email = trim(filter_input(INPUT_POST, 'email'));
    $password = trim(filter_input(INPUT_POST, 'password'));


    $validate->text('first_name', $first_name);
    $validate->text('last_name', $last_name);
    $validate->text('address', $address);
    $validate->text('city', $city);
    $validate->text('state', $state);
    $validate->zip('postal_code', $postal_code);
    $validate->phone('phone', $phone);
    $validate->email('email', $email);
    $validate->password('password', $password);
    // Load appropriate view based on hasErrors

    if ($fields->hasErrors()) {
        include ('customer_update_form.php');
    } else {
        update_customer($customer_id, $first_name, $last_name, $address, $city, $state, $postal_code, $country_code, $phone, $email, $password);

        include('customer_search.php');
    }
}
?>