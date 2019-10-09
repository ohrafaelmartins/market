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
            <div class="row">
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
                <div class="col text-danger">
                    {{message}}
                </div>

            </div>
            <hr>
            <div class="row">
                <table class="table table-striped table-bordered table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="text-center">ID</th>
                            <th scope="col" class="text-center">Name</th>
                            <th scope="col" class="text-center">Price</th>
                            <th scope="col" class="text-center">Product Type</th>
                            <th scope="col" class="text-center">-</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <tr v-for='product in products'>
                            <td class="text-center">{{ product.id }}</td>
                            <td class="text-center">{{ product.name }}</td>
                            <td class="text-center">R$ {{ product.price }}</td>
                            <td class="text-center">{{ product.name_products_type }}</td>
                            <td class="text-center"><button class="btn btn-danger btn-sm" v-on:click="deleteProduct(product.id)">Delete</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
</body>
<script>
var app = new Vue({
    el: '#vueapp',
    data: {
        name: '',
        price: '',
        id_products_type: '',
        id_products_type_sel: '',
        last_name_product_type: '',
        products: [],
        products_type: [],
        message: '',
    },
    mounted: function() {
        this.getProducts()
        this.getProductsType()
    },
    methods: {
        onChange(e) {
            app.last_name_product_type = e.target.options[e.target.options.selectedIndex].label
        },
        getProducts: function() {
            axios.get('axios.php?getProducts=true')
                .then(function(response) {
                    app.products = response.data;
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        getProductsType: function() {
            axios.get('axios.php?getProductsType=true')
                .then(function(response) {
                    app.products_type = response.data;
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        deleteProduct: function(id) {
            let formData = new FormData();
            formData.set('id', id)
            formData.set('delete-product', true)
            var product = {};
            axios({
                    method: 'post',
                    url: 'axios.php',
                    data: formData,
                    config: {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                })
                .then(function(response) {
                    if (response.data.status == 200) {
                        app.setMessage("delete successful")
                        app.getProducts()
                        app.resetForm();
                    } else {
                        app.setMessage(response.data.error)
                    }
                })
                .catch(function(response) {});
        },
        createProduct: function() {
            let formData = new FormData();
            formData.set('name', this.name)
            formData.set('price', this.price)
            formData.set('id_products_type', this.id_products_type_sel)
            formData.set('id', this.id)
            var product = {};
            formData.forEach(function(value, key) {
                product[key] = value;
            });
            axios({
                    method: 'post',
                    url: 'createProduct.php',
                    data: formData,
                    config: {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                })
                .then(function(response) {
                    if (response.data.status == 200) {
                        product.id = response.data.lastId
                        product.name_products_type = app.last_name_product_type
                        app.products.push(product)
                        app.setMessage("registration successful")
                        app.resetForm();
                    } else {
                        app.setMessage(response.data.error)
                    }
                })
                .catch(function(response) {});
        },
        resetForm: function() {
            this.name = '';
            this.price = '';
            this.id_products_type = '';
        },
        setMessage: function(msg) {
            app.message = msg;
            setTimeout(function() {
                app.message = "";
            }, 2000);
        }
    }
})
</script>

</html>