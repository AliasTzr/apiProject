<?php
require_once("./fonctions.php");
try{
    //routage
    if(!empty($_GET['demande'])){
        $url = explode("/", filter_var($_GET['demande'], FILTER_SANITIZE_URL));
    if($url[0] == "products"){
        if(empty($url[1]))
        {
            getProducts();
            if(!empty($_POST['name']) AND !empty($_POST['description']) AND !empty($_POST['price']) AND !empty($_POST['inStock']))
            {
                if(intval($_POST['price'])>0)
                {
                    if($_POST['inStock'][0] == "f" OR $_POST['inStock'][0] == "t")
                    {
                        $name = $_POST['name'];
                        $description = $_POST['description'];
                        $price = intval($_POST['price']);
                        $inStock = $_POST['inStock'][0];
                        insertDataFromUser($name, $description, $price, $inStock);
                    }
                    else
                    {
                        throw new Exception ("Valeur boolénne incorrecte");
                    }
                }
                else
                {
                    throw new Exception ("prix incorrecte");
                }
            }
        }
        else if(!empty($url[1]))
        {
            if(intval($url[1])>0)
            {
                $infos = getProductById($url[1]);
                echo $infos;
                //$info = json_decode($infos);
                if(!empty($_POST['newName']) AND $_POST['newName'] != $info[0]->name)
                {
                    $message = updateName($_POST['newName'], $info[0]->id);
                    echo $message;
                }
                if(!empty($_POST['newDescription']) AND $_POST['newDescription'] != $info[0]->description)
                {
                    $message = updatePrice($_POST['newPrice'], $info[0]->id);
                    echo $message;
                }
                if(!empty($_POST['newInStock']) AND $_POST['newDescription'] != $info[0]->description)
                {
                    $message = updateInStock($_POST['newInStock'], $info[0]->id);
                    echo $message;
                }
                if(!empty($_POST['deleteId']))
                {
                    if($_POST['deleteId'] == $info[0]->id)
                    {
                        $message = deleteDataFromUser($info[0]->id);
                        echo $message;
                    }
                    else
                    {
                        echo "Suppression impossible";
                    }
                    
                }
            }
            else
            {
                throw new Exception ("Id pas correct");
            }
        }
        }
        else
        {
            throw new Exception ("erreur de requête");
        }
    }
    else
    {
        throw new Exception ("Reccuperation failed");
    }
    
} catch(Exception $e){
    $erreur=[
        "message" => $e->getMessage(),
        "code" => $e->getCode()
    ];
    print_r($erreur);
    
}
