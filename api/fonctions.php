<?php
 function getProducts(){
    $connect = connexion();
    $statut = pg_query($connect, "SELECT * FROM products ORDER BY id");
    $produits = pg_fetch_all($statut);
    echo sendToUser($produits);
 }

 function getProductById($id){
    $connect = connexion();
    $statut = pg_query($connect, "SELECT * FROM products WHERE id = $id");
    $produits = pg_fetch_all($statut);
    return sendToUser($produits);
    
}

function insertDataFromUser($name, $description, $price, $inStock)
{
    $instock = 'TRUE';
    if($inStock == 'f') $instock = 'FALSE';
    $connect = connexion();
    $result = pg_prepare($connect, "my_query", 'INSERT INTO products (name, description, price, inStock) VALUES ($1, $2, $3, $4)');
    $result = pg_execute($connect, "my_query", array($name, $description, $price, $instock));
}


function updateDataFromUser($name, $price, $description, $inStock, $id)
{
    $instock = 'TRUE';
    if($inStock == 'f') $instock = 'FALSE';
    $connect = connexion();
    $result = pg_prepare($connect, "my_query", 'UPDATE products SET name=$1, description=$2, price=$3, inStock =$4 WHERE id=$5');
    $result = pg_execute($connect, "my_query", array($name, $description, $price, $instock, $id));
    return json_encode(['message'=> 'Modified!']); #"{ message: 'Modified!' }";
}

function deleteDataFromUser($id)
{
    $connect = connexion();
    $result = pg_prepare($connect, "my_query", 'DELETE FROM products WHERE id = $1');
    $result = pg_execute($connect, "my_query", array($id));
    return json_encode(['message'=> 'Deleted!']); #"{ message: 'Deleted!' }";
}

function connexion(){
    return pg_connect("host=ec2-34-206-245-175.compute-1.amazonaws.com dbname=dfhg0uoil21hl7 user=jzvzsfcurpgzvv password=fa4871d3ecd117e4da21a28807c9b9fe20f26ec9adb0788ef03169a2b026399b");
}

function sendToUser($infos){
    header('Content-Type: application/json');
    return json_encode($infos, JSON_UNESCAPED_UNICODE);
}

