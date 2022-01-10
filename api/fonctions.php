<?php
 function getProducts(){
    $connect = connexion();
    $statut = pg_query($connect, "SELECT * FROM products");
    $produits = pg_fetch_all($statut);
    $infos = sendToUser($produits);
    echo json_encode(['produits'=> $infos]); #"{products: $infos}";
 }

 function getProductById($id){
    $connect = connexion();
    $statut = pg_query($connect, "SELECT * FROM products WHERE id = $id");
    $produits = pg_fetch_all($statut);
    return sendToUser($produits);
    
}

function insertDataFromUser($name, $description, $price, $inStock)
{
    $connect = connexion();
    if($inStock == "f")
    {
        pg_insert($connect, 'products', array('name'=>$name, 'description'=>$description, 'price'=>$price, 'inStock'=>FALSE));
    }
    if($inStock == "t")
    {
        pg_insert($connect, 'products', array('name'=>$name, 'description'=>$description, 'price'=>$price, 'inStock'=>TRUE));
    }
}

function updateName($name, $id)
{
    $connect = connexion();
    //$stat = pg_update($connect, 'produits', array('id'=>$id), array('name'=>$name));
    pg_query($connect, "UPDATE products SET name = '$name' WHERE id = $id");
    return json_encode(['message'=> 'Modified!']); #"{ message: 'Modified!' }";
}

function updateDescription($description, $id)
{
    $connect = connexion();
    pg_query($connect, "UPDATE products SET description = '$description' WHERE id = $id");
    return json_encode(['message'=> 'Modified!']); #"{ message: 'Modified!' }";
}

function updatePrice($price, $id)
{
    $connect = connexion();
    pg_query($connect, "UPDATE products SET price = '$price' WHERE id = $id");
    return json_encode(['message'=> 'Modified!']); #"{ message: 'Modified!' }";
}

function updateInStock($inStock, $id)
{
    $connect = connexion();
    if($inStock[0] == "f")
    {
        pg_query($connect, "UPDATE products SET inStock = FALSE WHERE id = $id");
    }
    if($inStock[0] == "t")
    {
        pg_query($connect, "UPDATE products SET inStock = TRUE WHERE id = $id");
    }
    return json_encode(['message'=> 'Modified!']) #"{ message: 'Modified!' }";
}

function deleteDataFromUser($id)
{
    $connect = connexion();
    pg_query($connect, "DELETE FROM products WHERE id = $id");
    return json_encode(['message'=> 'Deleted!']); #"{ message: 'Deleted!' }";
}

function connexion(){
    return pg_connect("host=ec2-34-206-245-175.compute-1.amazonaws.com dbname=dfhg0uoil21hl7 user=jzvzsfcurpgzvv password=    fa4871d3ecd117e4da21a28807c9b9fe20f26ec9adb0788ef03169a2b026399b");
}

function sendToUser($infos){
    header('Content-Type: application/json');
    return json_encode($infos, JSON_UNESCAPED_UNICODE);
}

