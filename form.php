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
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <title>Jersey Store</title>
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
    </body>
</html>