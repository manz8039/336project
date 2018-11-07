<?php
session_start();

include 'functions.php';

/*
// remove this code after you have updated with latest repository
if(!function_exists('startConnection')) {
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
    
}*/

if(!empty($_GET['id'])) {
    $id = intval($_GET['id']);
    $info = displayProduct($id);
    /*if($info) {
        print_r($info);
    
    }*/
} else {
    print 'No valid id';
    die();
}


function getProduct($id) {
    global $dbConn;
    $pdo = $dbConn;
    //$mysqliConn = mysqli_connect('us-cdbr-iron-east-01.cleardb.net','b831dbdd87260c','d170c72e', 'heroku_c149aff39c41e5d');
    $rows = array();
     
    $sql = 'select * from sc_product INNER JOIN sc_category '
        .'ON sc_product.catid = sc_category.catid WHERE sc_product.prodId = :id';//.$id;
    $query = $pdo->prepare($sql);
    $query->execute(['id' => $id]); 
    $result = $query->fetch();
    return $result;    
}    
    //$result = mysqli_query($mysqliConn, $sql);
    /* $host = "us-cdbr-iron-east-01.cleardb.net";
    $username = "b831dbdd87260c";
    $password = "d170c72e";
    $dbname = "heroku_c149aff39c41e5d"
    */
    //foreach ($conn->query($sql) as $row) {
    /*Array ( [prodId] => 41 [0] => 41 [team] => Chelsea FC [1] => Chelsea FC 
    [description] => Chelsea FC is in the midst of the club’s Golden Era which started in 2003 when Roman Abramovich bought the London club. 
    [2] => Chelsea FC is in the midst of the club’s Golden Era which started in 2003 when Roman Abramovich bought the London club. 
    [price] => 89.99 [3] => 89.99 [image] => https://www.imagehandler.net/?iset=0108&img=A1010480000&fmt=png&w=300&h=300&iindex=0007&c=999&cmp=85 [4] => https://www.imagehandler.net/?iset=0108&img=A1010480000&fmt=png&w=300&h=300&iindex=0007&c=999&cmp=85 
    [catId] => 1 [5] => 1 [6] => 1 [catName] => Soccer [7] => Soccer ) 
    */
    /*foreach ($dbConn->query($sql) as $row) {
        $rows[] = $row;
    }*/
    //$row = mysqli_fetch_array($result);
function displayProduct($id) {
    $row = getProduct($id);

    if(!$row) {
        print 'No product matching that id';    
    
    } else {
        //print_r($row);
        $product = $row;
        print '<h3>'.$product['team'].'</h3>';
        print "<img src='" . $product['image'] . "' width='200' height='175'>";
        print '<div class="description">'.$product['description'].'</div>';
        print '<div class="price">$'.$product['price'].'</div>';
        
        $_SESSION['image'] = $product['image'];
        $_SESSION['team'] = $product['team'];
        $_SESSION['price'] = $product['price'];
        
    }
    return $row;
    
}
