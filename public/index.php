<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
function __autoload($class_name)
{
    require_once 'class/' . $class_name . '.php';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP| MySQL | Vue.js | Axios Example</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>

<body>
    <div id='vueapp'>
        <div class="container">
            <hr>
            <a href="products_.php" class="badge badge-success">product</a>
            <a href="productstype_.php" class="badge badge-success">product type</a>
            <a href="sale_.php" class="badge badge-success">sale</a>
            <hr>


            <!-- <div class="row">
                <div class="col">
                    <form>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label col-form-label-sm">Name</label>
                            <div class="col-sm-9">
                                <input placeholder="Product name" class="form-control form-control-sm" type="text"
                                    name="name" id="name" v-model="name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label col-form-label-sm">Price</label>
                            <div class="col-sm-9">
                                <input placeholder="Product price" class="form-control form-control-sm" type="number"
                                    name="price" id="price" v-model="price">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label col-form-label-sm">Product Type</label>
                            <div class="col-sm-9">
                                <select @change="onChange($event)" v-model="id_products_type_sel"
                                    class="custom-select my-1 mr-sm-2 form-control-sm" id="id_products_type_sel"
                                    v-model="">
                                    <option v-for='(product_type, key) in products_type' :value="product_type.id"
                                        selected>
                                        {{ product_type.name }}</option>
                                </select>
                            </div>
                        </div>
                        <input class="btn btn-primary" type="button" @click="createProduct()"
                            value="Register new product">
                    </form>
                </div>
                <div class="col">
                    .
                </div>
            </div> -->

            <!-- <div class="row">
                <table class="table table-striped table-bordered table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="text-center">ID</th>
                            <th scope="col" class="text-center">Name</th>
                            <th scope="col" class="text-center">Price</th>
                            <th scope="col" class="text-center">Product Type</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <tr v-for='product in products'>
                            <td class="text-center">{{ product.id }}</td>
                            <td class="text-center">{{ product.name }}</td>
                            <td class="text-center">R$ {{ product.price }}</td>
                            <td class="text-center">{{ product.name_products_type }}</td>
                        </tr>
                    </tbody>
                </table>
            </div> -->
        </div>
</body>

</html>