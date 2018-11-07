<?php
include 'functions.php';

session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if (isset($_GET['query'])) {
    include 'wmapi.php';
    $items = getProducts($_GET['query']);
}


if (isset($_POST['itemName'])) {
    
    $newItem = array();
    $newItem['name'] = $_POST['itemName'];
    $newItem['id'] = $_POST['itemId'];
    $newItem['price'] = $_POST['itemPrice'];
    $newItem['image'] = $_POST['itemImage'];
    
    foreach ($_SESSION['cart'] as &$item) {
        if ($newItem['id'] == $item['id']) {
            $item['quantity'] += 1;
            $found = true;
        }
    }
    
    if (!$found) {
        $newItem['quantity'] = 1;
        array_push($_SESSION['cart'], $newItem);
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/styles.css" type="text/css" />
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        
        <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" type="text/css" />-->

        <title>Jersey Store</title>
        
        <script>
            function openModal() {
                $('#myModal').modal("show");
            }
            
            function addToCart() {
            
                alert( " The item has been added to your cart. <?php updateCart() ?>");
                document.location.reload(true);
            }
        </script>
    </head>
    <body>
    <div class='container'>
        <div class='text-center'>
            
            <!-- Bootstrap Navagation Bar -->
            <nav class='navbar navbar-default - navbar-fixed-top'>
                <div class='container-fluid'>
                    <div class='navbar-header'>
                        <a class='navbar-brand' href='#'>Jersey Store</a>
                    </div>
                    <ul class='nav navbar-nav'>
                        <li><a href='index.php'>Home</a></li>
                        <li><a href='scart.php'>
                            <span class='glyphicon glyphicon-shopping-cart' aria-hidden='true'></span> Cart: <?= displayCartCount(); ?> </a></li>
                    </ul>
                </div>
            </nav>
            <br /> <br /> <br />
            
            <!-- Search Form -->
            <div class="filters">
                <h2>
                    Shop for jerseys below
                </h2>
                <form>
                    Search: 
                    <input type="text" name="product"/> <br>
                    
                    Category:
                        <select name="category">
                            <?= displayCategories() ?>
                        </select>
                    <br>
                    
                    Sort price by:
                    <input type="radio" name="sort" value="cheap"/> Ascending
                    <input type="radio" name="sort" value="expensive"/> Descending <br>
                    
                    Check to display <strong>ONLY</strong>  on sale items
                    <input type='checkbox' name='sale' value='y'> <br><br>
                    
                    <input type="submit" value="Shop" name="searchForm"/>
                </form>
                <br>
            </div>
            <!-- Display Search Results -->
            <?= displaySearchResults() ?>
            
        </div>
    </div>
    
<!-- Button trigger modal
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
  Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Product Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <iframe name="productModal" width="450" height="250"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button onclick="addToCart()"  class="btn btn-primary">Add to cart</button>
      </div>
    </div>
  </div>
</div>



    </body>
</html>