<?php

function startConnection() {
    // Creating connection
    $host = "us-cdbr-iron-east-01.cleardb.net";
    $username = "b831dbdd87260c";
    $password = "d170c72e";
    $dbname = "heroku_c149aff39c41e5d";
    
    $dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $dbConn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    return $dbConn;
}

$dbConn = startConnection();

function sampleData() {
    global $dbConn;
    $sql = "SELECT * FROM sc_product";
    $stmt = $dbConn->prepare($sql);
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($records);
}

function displayCartCount() {
    echo count($_SESSION['cart']);
}

function displayResults() {
    global $items;
    if (isset($items)) {
        echo "<table class='table'>";
        foreach ($items as $item) {
            $itemName = $item['name'];
            $itemPrice = $item['salePrice'];
            $itemImage = $item['thumbnailImage'];
            $itemId = $item['itemId'];
            
            echo "<tr>";
            
            echo "<td><img src='$itemImage'></td>";
            echo "<td><h4>$itemName</h4></td>";
            echo "<td><h4>$$itemPrice</h4></td>";
            
            echo "<form method='post'>";
            echo "<input type='hidden' name='itemName' value='$itemName'>";
            echo "<input type='hidden' name='itemId' value='$itemId'>";
            echo "<input type='hidden' name='itemImage' value='$itemImage'>";
            echo "<input type='hidden' name='itemPrice' value='$itemPrice'>";
            
            if ($_POST['itemId'] == $itemId) {
                echo "<td><button class='btn btn-warning' style='background-color:green;'>Added</button></td>";
            }
            else {
                echo "<td><button class='btn btn-warning'>Add</button></td>";
            }
            echo "</form>";
            echo "</tr>";
        }
        echo "</table>";
    }
}
function displayCart() {
    if (isset($_SESSION['cart'])) {
        echo "<table class='table>";
        foreach ($_SESSION['cart'] as $item) {
            $itemName = $item['name'];
            $itemPrice = $item['price'];
            $itemImage = $item['image'];
            $itemId = $item['id'];
            $itemQuantity = $item['quantity'];
            
            echo "<tr>";
            echo "<td><img src='$itemImage'></td>";
            echo "<td><h4>$itemName</h4></td>";
            echo "<td><h4>$$itemPrice</h4></td>";
            
            echo "<form method='post'>";
            echo "<input type='hidden' name='itemId' value='$itemId'>";
            echo "<td><input type='text' name='update' class='form-control' placeHolder='$itemQuantity'></td>";
            echo "<td><button class='btn btn-danger'>Update</button></td>";
            echo "</form>";
            
            echo "<form method='post'>";
            echo "<input type='hidden' name='removeId' value='$itemId'>";
            echo "<td><button class='btn btn-danger'>Remove</button></td>";
            echo "</form>";
            echo "</tr>";
        }
        echo "</table>"; 
    }
}
?>