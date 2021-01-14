<?php

// provides connection to database
$pdo= new PDO('mysql:host=localhost; port=3306; dbname=project','root','');
// if connection is unsuccessful throws an error
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sku = '';
$name = '';
$price = '';
$size = '';
$height = '';
$width = '';
$length = '';
$weight = '';
$type='';


// create variables for info we want to send to database
if($_SERVER["REQUEST_METHOD"]==='POST'){

    $sku = $_POST['sku'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $size = $_POST['size'];
    $height = $_POST['height'];
    $width = $_POST['width'];
    $length = $_POST['length'];
    $weight = $_POST['weight'];
    $type = 'none';
    if(!empty($_POST['types'])){
        $type = $_POST['types'];
    };

// validations

    $errors =[];

    if(!$sku){
        $errors[]='Product sku is required';
    }

    if(!$name){
        $errors[]='Product name is required';
    }
    if(!$price){
        $errors[]='Product price is required';
    }
    if($type=='none'){
        $errors[]='choose type';
    }
    if($type!='none'){


        if(!$size && $type=='disc'){
            $errors[]='Product size is required';
        }
        if(!$height && $type=='furniture'){
            $errors[]='Product height is required';
        }
        if(!$width && $type=='furniture'){
            $errors[]='Product width is required';
        }
        if(!$length && $type=='furniture'){
            $errors[]='Product length is required';
        }
        if(!$weight && $type=='book'){
            $errors[]='Product weight is required';
        }
    }


    if(empty($errors)){

// query for inserting records into products table in mysql

        $statement = $pdo->prepare("INSERT INTO products (sku,name,price,length,width,height,size,weight,type)
                                   VALUES(:sku,:name,:price,:length,:width,:height,:size,:weight,:type)");

// binding values
        $statement ->bindValue(':sku',$sku);
        $statement ->bindValue(':name',$name);
        $statement ->bindValue(':price',$price);
        $statement ->bindValue(':length',$length);
        $statement ->bindValue(':width',$width);
        $statement ->bindValue(':height',$height);
        $statement ->bindValue(':size',$size);
        $statement ->bindValue(':weight',$weight);
        $statement ->bindValue(':size',$size);
        $statement ->bindValue(':type',$type);

// execution of above written query

        $statement->execute();
        header('Location:product_list.php');

    }


}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add product</title>
    <link rel="stylesheet" href="product_add_style.css" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>


<header>
    <h1 id="title">Product Add</h1>
</header>
<hr>
<div class="errors">
<?php if(!empty($errors)):?>
<?php foreach($errors as $error): ?>
<p id="error"><?php echo $error?></p>
<?php endforeach ?>
<?php endif ?>
</div>
<form method="POST">
    <div class="box">
        <lable for="sku">SKU</lable>
        <input type="text" id="sku" placeholder="Enter SKU" name="sku" value="<?php echo $sku; ?>">
    </div>

    <div class="box">
        <lable for="name">Name</lable>
        <input type="text" id="name" placeholder="Enter name" name="name" value="<?php echo $name; ?>">
    </div>

    <div class="box">
        <lable for="price">Price</lable>
        <input type="text" id="price" placeholder="Enter price" name="price" value="<?php $price?>">
    </div>

    <div class="conteiner">

        <div>select any option from following</div><br>
        <select id="se" name="types">
            <option selected disabled>Choose type</option>
            <option>book</option>
            <option>furniture</option>
            <option>disc</option>
        </select>
        <br>
        <br>



        <script>
            // it shows different div for each selection
            // for example if we choose book this unit will show us div with id "book"
            $("select").change(function(){

                if(document.getElementById("se").value=="book"){

                    document.getElementById('book').style.display = 'block';
                    document.getElementById('furniture').style.display = 'none';
                    document.getElementById('disc').style.display = 'none';
                }
                if(document.getElementById("se").value=="furniture"){

                    document.getElementById('book').style.display = 'none';
                    document.getElementById('furniture').style.display = 'block';
                    document.getElementById('disc').style.display = 'none';
                }
                if(document.getElementById("se").value=="disc"){

                    document.getElementById('book').style.display = 'none';
                    document.getElementById('furniture').style.display = 'none';
                    document.getElementById('disc').style.display = 'block';
                }


            })
        </script>

            <div id="disc" style="display:none">

                <lable for="size">size</lable>
                <input type="text"  id="size" name="size">
                <p>Please provide size of disc</p>
            </div>
            <div id="furniture" style="display:none">
                <lable for="height">Height</lable>
                <input type="height"  id="height" name="height"><br>
                <lable for="width">Width</lable>
                <input type="width"  id="width" name="width"><br>
                <lable for="length" >Length</lable>
                <input type="text"  id="length" name="length"><br>
                <p>Please provide dimenstions of furniture</p>
            </div>
            <div id="book" style="display:none">
                <lable for="weight" style="display:none">weight</lable>
                <input type="text"  id="weight" name="weight">
                <p>Please provide weight of book</p>
            </div>



        <input type="submit" value="save">
    </div>
</form>




</body>
</html>