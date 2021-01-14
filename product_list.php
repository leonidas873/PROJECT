<?php


// provides connection to database
$pdo= new PDO('mysql:host=localhost; port=3306; dbname=project','root','');
// if connection is unsuccessful throws an error
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

// gets all information from products table
$statement = $pdo->prepare('SELECT * FROM products');
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>product list</title>
    <link rel="stylesheet" href="product_list_style.css">
</head>
<body>
<header>
    <h1>Product List</h1>
    <div class="btns">
        <a id="add" href="product_add.php">add product</a>
    </div>

</header>
<hr>
<div class="conteiner">
    <!-- with this peace of code we get as many boxes as products -->
    <?php foreach ($products as $product){?>
        <div class="frame">
            <div class="mark">
                <lable for="marking"></lable>
                <input type="checkbox" id="marking" name="marking">
            </div>
            <div class="box">
                <p class="sku"><?php echo $product['sku']; ?>></p>
                <p class="name"><?php echo $product['name']; ?></p>
                <p class="price"><?php echo $product['price'].' $'; ?></p>
                <p class="property"><?php

                    if($product['type']==='disc'){
                        echo 'Size: '.$product['size'].'mb';
                    } else if($product['type']==='furniture'){
                        echo 'Dimension:'.$product['height'].'x'.$product['width'].'x'.$product['length'].'x';
                    } else if($product['type']==='book'){
                        echo 'wight: '.$product['weight'].'kg';
                    } else{
                        echo 'no property';
                    }


                    ?></p>
                <a href="delete.php?id=<?php echo $product['id']?>" style="text-decoration: none; color:black; margin-bottom: 10px; border:1px solid black; border:radius:3px; background-color:red;">delete</a>
            </div>

        </div>
    <?Php }?>

</div>
</body>
</html>
