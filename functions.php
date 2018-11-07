<?php
session_start();
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

function displayCategories()
{
    global $dbConn;
    
    $sql = "SELECT * FROM sc_category ORDER BY catName";
    $statement = $dbConn -> prepare($sql);
    $statement -> execute();
    $records = $statement -> fetchAll();
    
    echo "<option value=''>Select One</option>";
    
    foreach ($records as $record)
    {
        echo "<option value='". $record['catId'] ."'>" . $record['catName'] . "</option>";
    }
}

function displaySearchResults()
{
    global $dbConn;
    
    if (isset($_GET['searchForm']))
    {
        // checks is user has subbmitted form
        echo"<h3>Products Found: </h3>";
        $namedParamters = array();
        
        //$sql = "SELECT * FROM sc_product WHERE 1";
        
        // checks if user wants ONLY on sale items
        if ($_GET['sale'] == 'y')
        {
            $sql  = "SELECT * from sc_product p INNER JOIN sc_sale s ON p.prodId = s.productId WHERE 1";
        }
        else
        {
            $sql = "SELECT * from sc_product p LEFT JOIN sc_sale s ON p.prodId = s.productId WHERE 1";
        }
        
        if (!empty($_GET['product']))
        {
            // checks if user has typed something in product text box
            $sql .= " AND description LIKE :description";
            $namedParamters[":description"] = "%" . $_GET['product'] . "%";
        }
        
        if (!empty($_GET['category']))
        {
            // checks if user has selected a category
            $sql .= " AND catId = :catId";
            $namedParamters[":catId"] = $_GET['category'];
        }
        
        if (isset($_GET['sort']))
        {
            // checks how to sort
            if ($_GET['sort'] == "cheap")
            {
                $sql .= " ORDER BY price ASC";
            }
            else
            {
                $sql .= " ORDER BY price DESC";
            }
        }
        
        $statement = $dbConn->prepare($sql);
        $statement->execute($namedParamters);
        $records = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($records as $record)
        {
          //print_r($record);
            //echo $record["team"] . " " . $record["description"] . " $" . $record["price"] . "<br/>" . "<img src='" . $record["image"] . "width ='200' height='400'>" . "<br/>";
            echo "<a onclick='openModal()' target='productModal' href = 'display.php?id=".$record['prodId']."'>" . $record["team"] . " " . $record["description"] . " $" . $record["price"] . "<br/>" . "<img src='" . $record["image"] . " width ='200' height='400'>" . "</a><br/>";
           // echo $record["team"] . " " . $record["description"];
            
            if ($record["salePrice"] == NULL)
            {
                //echo " $" . $record["price"] . "<br/> <img src='" . $record["image"] . "width ='200' height='400'>" . "<br/>";
            }
            else
            {
                //echo "<strike> $" . $record["price"] ."</strike> $" .  $record["salePrice"] . "<br/> <img src='" . $record["image"] . "width ='200' height='400'>" . "<br/>";
            }
//>>>>>>> aa4fbd598aedf59a42b1f4423e85b7012ca5bc81
        }
    }
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
        echo "<table class='table'>";
        foreach ($_SESSION['cart'] as $item) {
            $itemName = $item['team'];
            $itemPrice = $item['price'];
            $itemImage = $item['image'];
            //$itemId = $item['id'];
            //$itemQuantity = $item['quantity'];
            
            echo "<tr>";
            echo "<td><img src='$itemImage' width='100' height='100'></td>";
            echo "<td><h4>$itemName</h4></td>";
            echo "<td><h4>$$itemPrice</h4></td>";
            
            /*echo "<form method='post'>";
            echo "<input type='hidden' name='itemId' value='$itemId'>";
            echo "<td><input type='text' name='update' class='form-control' placeHolder='$itemQuantity'></td>";
            echo "<td><button class='btn btn-danger'>Update</button></td>";
            echo "</form>";
            
            echo "<form method='post'>";
            echo "<input type='hidden' name='removeId' value='$itemId'>";
            echo "<td><button class='btn btn-danger'>Remove</button></td>";
            echo "</form>";*/
            echo "</tr>";
        }
        echo "</table>"; 
    }
}
function updateCart(){
    if(!empty($_SESSION['image'])){
        $newItem = array();
        $newItem['image'] = $_SESSION['image'];
        $newItem['team'] = $_SESSION['team'];
        $newItem['price'] = $_SESSION['price'];
                    
        $_SESSION['cart'][] = $newItem;
        
        unset($_SESSION['image']);
        unset($_SESSION['team']);
        unset($_SESSION['price']);
    }
}
?>