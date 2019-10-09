<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
function __autoload($class_name)
{
    require_once 'class/' . $class_name . '.php';
}
$method = $_SERVER['REQUEST_METHOD'];
if ($method == "POST" && !empty($_POST)) {
    $products = new Products();
    $products->setName($_POST['name']);
    $products->setPrice($_POST['price']);
    $products->setId_products_type($_POST['id_products_type']);
    if ($products->insert()) {
        $products->setId(DB::getLastId());
        echo json_encode(array("status" => "200", "lastId" => $products->getId()));
        exit;
    }
    echo json_encode(array("status" => "00", "error" => "Error"));
}
