<?php
 function getProducts(){
    $connect = connexion();
    $statut = pg_query($connect, "SELECT * FROM produits");
    $produits = pg_fetch_all($statut);
    $infos = sendToUser($produits);
    echo "{products: $infos}";
 }

 function getProductById($id){
    $connect = connexion();
    $statut = pg_query($connect, "SELECT * FROM produits WHERE id = $id");
    $produits = pg_fetch_all($statut);
    return sendToUser($produits);
    
}

function insertDataFromUser($name, $description, $price, $inStock)
{
    $connect = connexion();
    if($inStock == "f")
    {
        pg_insert($connect, 'produits', array('name'=>$name, 'description'=>$description, 'price'=>$price, 'inStock'=>FALSE));
    }
    if($inStock == "t")
    {
        pg_insert($connect, 'produits', array('name'=>$name, 'description'=>$description, 'price'=>$price, 'inStock'=>TRUE));
    }
}

function updateName($name, $id)
{
    $connect = connexion();
    //$stat = pg_update($connect, 'produits', array('id'=>$id), array('name'=>$name));
    pg_query($connect, "UPDATE produits SET name = '$name' WHERE id = $id");
    return "{ message: 'Modified!' }";
}

function updateDescription($description, $id)
{
    $connect = connexion();
    pg_query($connect, "UPDATE produits SET description = '$description' WHERE id = $id");
    return "{ message: 'Modified!' }";
}

function updatePrice($price, $id)
{
    $connect = connexion();
    pg_query($connect, "UPDATE produits SET price = '$price' WHERE id = $id");
    return "{ message: 'Modified!' }";
}

function updateInStock($inStock, $id)
{
    $connect = connexion();
    if($inStock[0] == "f")
    {
        pg_query($connect, "UPDATE produits SET inStock = FALSE WHERE id = $id");
    }
    if($inStock[0] == "t")
    {
        pg_query($connect, "UPDATE produits SET inStock = TRUE WHERE id = $id");
    }
    return "{ message: 'Modified!' }";
}

function deleteDataFromUser($id)
{
    $connect = connexion();
    pg_query($connect, "DELETE FROM produits WHERE id = $id");
    return "{ message: 'Deleted!' }";
}

function connexion(){
    return pg_connect("host=localhost dbname=Product user=postgres password=root");
}

function sendToUser($infos){
    header('Content-Type: application/json');
    return json_encode($infos, JSON_UNESCAPED_UNICODE);
}

