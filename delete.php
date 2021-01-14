<?php
// provides connection to database
$pdo= new PDO('mysql:host=localhost; port=3306; dbname=project','root','');
// if connection is unsuccessful throws an error
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

// if id doesnt exist we will go back to product list page
$id = $_GET['id'] ?? null;
if(!$id) {
    header('Location:product_list.php');
    exit;
}
// gets all information from products table
$statement = $pdo->prepare('DELETE FROM products WHERE id = :id');
$statement->bindValue(':id',$id);
$statement->execute();

// after deleting product we instantly going back to product_list page
header('Location:product_list.php');

