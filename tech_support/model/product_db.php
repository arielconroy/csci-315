<?php

declare(strict_types = 1);

function get_products() {
    global $db;
    $query = 'SELECT * FROM products
              ORDER BY name';
    $statement = $db->prepare($query);
    $statement->execute();
    $products = $statement->fetchAll();
    $statement->closeCursor();
    return $products;
}

function get_products_by_customer($email) {
    global $db;
    $query = 'SELECT products.productCode, products.name 
              FROM products
                INNER JOIN registrations ON products.productCode = registrations.productCode
                INNER JOIN customers ON registrations.customerID = customers.customerID
              WHERE customers.email = :email';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $products = $statement->fetchAll();
    $statement->closeCursor();
    return $products;
}

function get_product($product_code) {
    global $db;
    $query = 'SELECT * FROM products
              WHERE productCode = :product_code';
    $statement = $db->prepare($query);
    $statement->bindValue(':product_code', $product_code);
    $statement->execute();
    $product = $statement->fetch();
    $statement->closeCursor();
    return $product;
}

function delete_product($product_code) {
    global $db;
    $query = 'DELETE FROM products
              WHERE productCode = :product_code';
    $statement = $db->prepare($query);
    $statement->bindValue(':product_code', $product_code);
    $statement->execute();
    $statement->closeCursor();
}

function add_product(string $code, string $name, float $version, string $release_date) {
    global $db;
    $query = 'INSERT INTO products
                 (productCode, name, version, releaseDate)
              VALUES
                 (:code, :name, :version, :release_date)';
    $statement = $db->prepare($query);
    $statement->bindValue(':code', $code);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':version', $version);
    $statement->bindValue(':release_date', $release_date);
    $statement->execute();
    $statement->closeCursor();
}

function update_product(string $code, string $name, float $version, string $release_date) {
    global $db;
    $query = 'UPDATE products
              SET name = :name,
                  version = :version,
                  releaseDate = :release_date
              WHERE productCode = :product_code';
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':version', $version);
    $statement->bindValue(':release_date', $release_date);
    $statement->bindValue(':product_code', $code);
    $statement->execute();
    $statement->closeCursor();
}

?>