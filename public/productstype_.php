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
                            <label class="col-sm-3 col-form-label col-form-label-sm"> Taxes %</label>
                            <div class="col-sm-9">
                                <input placeholder="Product taxes" class="form-control form-control-sm" type="number"
                                    step="any" name="taxes" id="taxes" v-model="taxes">
                            </div>
                        </div>
                        <input class="btn btn-primary" type="button" @click="create()"
                            value="Register new product type">
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
                            <th scope="col" class="text-center">Taxes %</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <tr v-for='product_type in products_type'>
                            <td class="text-center">{{ product_type.id }}</td>
                            <td class="text-center">{{ product_type.name }}</td>
                            <td class="text-center">{{ product_type.taxes }}</td>
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
        id: '',
        name: '',
        taxes: '',
        products_type: [],
        message: '',
    },
    mounted: function() {
        this.getProductsType()
    },
    methods: {
        onChange(e) {
            app.last_name_product_type = e.target.options[e.target.options.selectedIndex].label
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
        create: function() {
            let formData = new FormData();
            formData.set('id', this.id)
            formData.set('name', this.name)
            formData.set('taxes', this.taxes)
            formData.set('create_product_type', true)
            var product_type = {};
            formData.forEach(function(value, key) {
                product_type[key] = value;
            });
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
                        product_type.id = response.data.lastId
                        product_type.name_products_type = app.last_name_product_type
                        app.products_type.push(product_type)
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