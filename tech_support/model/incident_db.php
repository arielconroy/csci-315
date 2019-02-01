<?php
function add_incident($customer_id, $product_code, $title, $description) {
    global $db;
    $date_opened = date('Y-m-d');  // get current date in yyyy-mm-dd format
    $query =
        'INSERT INTO incidents
            (customerID, productCode, dateOpened, title, description)
        VALUES (
               :customer_id, :product_code, :date_opened,
               :title, :description)';
    $statement = $db->prepare($query);
    $statement->bindValue(':customer_id', $customer_id);
    $statement->bindValue(':product_code', $product_code);
    $statement->bindValue(':date_opened', $date_opened);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':description', $description);
    $statement->execute();
    $statement->closeCursor();
}
?>