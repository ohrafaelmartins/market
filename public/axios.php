<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function __autoload($class_name)
{
    require_once 'class/' . $class_name . '.php';
}

$method = $_SERVER['REQUEST_METHOD'];

if (!empty($_SERVER['PATH_INFO'])) {
    $request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
}

if ($method === "GET") {

    if (isset($_GET["getProductsType"]) && $_GET["getProductsType"] == true) {
        $ProductsType = new ProductsType();
        print_r(json_encode($ProductsType->findAll()));
        return;
    }

    if (isset($_GET["getSales"]) && $_GET["getSales"] == true) {
        $sales = new Sales();
        print_r(json_encode($sales->findAll()));
        return;
    }

    if (isset($_GET["getProducts"]) && $_GET["getProducts"] == true) {
        $products = new Products();
        print_r(json_encode($products->findWithTaxes("products_type", "id_products_type")));
    }

}

if ($method == "POST" && isset($_POST["delete-product"]) && $_POST["delete-product"] == true) {
    $products = new Products();

    try {
        $products->delete($_POST["id"]);
        echo json_encode(array("status" => "200"));
    } catch (\Exception $e) {
        echo json_encode(array("status" => "00", "error" => $e->getMessage()));
    }
}

if ($method == "POST" && isset($_POST["delete-sale"]) && $_POST["delete-sale"] == true) {
    $sales = new Sales();

    try {
        $sales->delete($_POST["id"]);
        echo json_encode(array("status" => "200"));
    } catch (\Exception $e) {
        echo json_encode(array("status" => "00", "error" => $e->getMessage()));
    }
}

if ($method == "POST" && !empty($_POST) && isset($_POST["create_product_type"]) && $_POST["create_product_type"] == true) {

    $ProductsType = new ProductsType();
    $ProductsType->setName($_POST['name']);
    $ProductsType->setTaxes($_POST['taxes']);

    try {
        $ProductsType->insert();
        $ProductsType->setId(DB::getLastId());
        echo json_encode(array("status" => "200", "lastId" => $ProductsType->getId()));
        exit;
    } catch (\Exception $e) {
        echo json_encode(array("status" => "00", "error" => $e->getMessage()));
    }

    echo json_encode(array("status" => "00", "error" => "Error"));
}

if ($method == "POST" && !empty($_POST) && isset($_POST["newSale"]) && $_POST["newSale"] == true) {

    $_POST["productsale"] = json_decode($_POST["productsale"][0]);

    $sales = new Sales();

    $sales->setTotal_price($_POST['total_price']);
    $sales->setTax_amount(($_POST['tax_amount']));
    // $sales->setId_status($_POST['id_status']);
    $sales->setId_status(1);

    try {
        $sales->insert();
        $sales->setId(DB::getLastId());

        $ProductsSale = new ProductsSale();

        foreach ($_POST["productsale"] as $key => $value) {
            $ProductsSale->setName($value->product_name);
            $ProductsSale->setTaxes($value->product_taxes);
            $ProductsSale->setQuantity($value->product_quantity);
            $ProductsSale->setId_sales($sales->getId());
            $ProductsSale->setId_products($value->id_products);

            if (!$ProductsSale->insert()) {
                echo json_encode(array("status" => "00", "error" => "Products Sale Error"));
            }
        }

        echo json_encode(array("status" => "200", "lastId" => $sales->getId()));
        exit;
    } catch (\Exception $e) {
        echo json_encode(array("status" => "00", "error" => $e->getMessage()));
    }

    echo json_encode(array("status" => "00", "error" => "Error"));
}
