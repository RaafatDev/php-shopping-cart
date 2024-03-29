<?php 

    session_start(); 
    ##################################
    require ("./php/class_connection.php");
    require ("./php/class_items.php"); 
    $pdo = new Connection(); 
    ##################################
    
 

    require ("./php/component.php"); 


    if(isset($_POST['remove'])){
        if($_GET['action'] == 'remove'){
            foreach ($_SESSION['cart'] as $key => $value) {
                if($value["product_id"] == $_GET['id']){
                    // unset($_SESSION['cart'][$key]); 
                    array_splice($_SESSION['cart'], $key,1); 
                    echo "<script>alert('Product has been Removed ...')</script>";
                    echo "<script>window.location='cart.php'</script>";
                    
                }
            }
        }
    }
    if(isset($_POST['plus'])){

            for ($i=0; $i < count($_SESSION['cart']); $i++) { 
                
                                if($_SESSION['cart'][$i]["product_id"] == $_GET['id']){
                              
                                    $quantity = $_POST['quantity'] + 1; 
                                    $_SESSION['cart'][$i]['quantity'] = $quantity; 
                                }
                }
    }
    if(isset($_POST['minus'])){

        for ($i=0; $i < count($_SESSION['cart']); $i++) { 
            if($_SESSION['cart'][$i]["product_id"] == $_GET['id']){

                $quantity = $_POST['quantity'] - 1; 
                if ($quantity > 0 ) {
                   
                    $_SESSION['cart'][$i]['quantity'] = $quantity; 
                } else {
                    array_splice($_SESSION['cart'], $i,1); 
                    echo "<script>alert('Product has been Removed ...')</script>";
                    echo "<script>window.location='cart.php'</script>";

                }
            }
        }
    }

?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cart</title>
     <!-- Font-Awesome CDN  -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css" integrity="sha256-PF6MatZtiJ8/c9O9HQ8uSUXr++R9KBYu4gbNG5511WE=" crossorigin="anonymous" />
    <!-- bootstrap CDN - css -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- CSS file -->
    <link rel="stylesheet" type="text/css" href="style.css">
    
</head>
<body class="bg-light">

<?php 
    require ("./php/header.php"); 

?> 


<div class="container-fluid">


<div class="row px-5">
    <div class="col-md-7">
        <div class="shopping-cart">
            <h6>My Cart</h6>
            <hr/>


<?php 

$total = 0; 


if(isset($_SESSION['cart'])){
    $product_id = array_column($_SESSION['cart'], 'product_id'); 
    $items = new Items($pdo); 

            $total = $items->getCartItems($product_id, $total, $_SESSION['cart']); 
    
}else{
    
    echo "<h5>Cart is Empty</h5>"; 
}



    ?>

        </div>
    </div>
    <div class="col-md-4 offset-md-1 border rounded mt-5 bg-white h-25">
        <div class="pt-4">

            <h6>PRICE DETAILS</h6>
            <hr />
            <div class="row price-details">
                <div class="col-md-6">

                    <?php 
                        if(isset($_SESSION['cart'])){
                            $count = count($_SESSION['cart']); 
                            echo "<h6>Price ($count items)</h6>"; 
                            
                        }else {
                            
                            echo "<h6>price (0 items)</h6>"; 
                        }

                    ?> 
                    <h6>Delivery Charges</h6>
                    <hr />
                    <h6>Amount Payable</h6>
                </div>
                <div class="col-md-6">
                    <h6 class="test-php">&euro; <?php echo $total; ?> </h6>

                    <h6 class="text-success">Free</h6>
                    <hr/>
                    <h6>&euro;  <?php echo $total; ?></h6>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


 <!-- bootstrap CDN - JS -->
 <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>