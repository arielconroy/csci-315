<?php include '../view/header.php'; ?>
<main>

    <h2>Register Product</h2>
    <?php if (isset($message)) : ?>
        <p><?php echo $message; ?></p>
    <?php else: ?>
        <form action="." method="post" id="aligned">
    <!--            <input type="hidden" name="action" 
                   value="register_product">
            <input type="hidden" name="customer_id" 
                   value="<?php echo $_SESSION['customerID'] = $customer['customerID']; ?>">-->

            <label>Customer:</label>
            <label><?php echo htmlspecialchars($customer['firstName'] . ' ' .
            $customer['lastName'])
        ?></label>
            <br>
    <?php $_SESSION['customerID'] = $customer['customerID']; ?>
            <label>Product:</label>
            <select name="product_code">
                    <?php foreach ($products as $product) : ?>
                    <option value="<?php echo htmlspecialchars($product['productCode']); ?>">
                    <?php echo htmlspecialchars($product['name']); ?>
                    </option>
    <?php endforeach; ?>
            </select>
            <br>

            <label>&nbsp;</label>
            <input type="submit" value="Register Product" />
            <input type='hidden' name='action' value='logout_customer' />
            <input type='submit' value='Logout' />
        </form>
        <p>You are logged in as <?php echo $_SESSION['email']; ?>.</p>

<?php endif; ?>


</main>
<?php include '../view/footer.php'; ?>