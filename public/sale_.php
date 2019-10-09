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
                <div class="col text-danger">
                    {{message}}
                </div>
            </div>

            <div class="row">
                <div class="col-sm-3">
                    <form>
                        <!-- <div class="form-group row">
                            <label class="col-sm-3 col-form-label col-form-label-sm">Name</label>
                            <div class="col-sm-9">
                                <input placeholder="Product name" class="form-control form-control-sm" type="text"
                                    name="name" id="name" v-model="name">
                            </div>
                        </div> -->

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label col-form-label-sm">Product</label>
                            <div class="col-sm-9">
                                <select v-model="product_id" class="custom-select my-1 mr-sm-2 form-control-sm" id=""
                                    v-model="">
                                    <option v-for='(product, key) in products' :value="product.id" selected>
                                        {{ product.name }} - R$ {{ product.price }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label col-form-label-sm">Quantity</label>
                            <div class="col-sm-9">
                                <input class="form-control form-control-sm" type="number" name="quantity" id="quantity"
                                    min="1" v-model="quantity">
                            </div>
                        </div>
                        <div class="btn-group">
                            <input class="btn btn-success" type="button" @click="newSale()" value="Sale">

                            <input class="btn btn-primary" type="button" @click="addToCart()" value="Add to cart">
                        </div>

                    </form>
                </div>

                <div class="col">
                    <h1>Cart</h1>
                    <table class="table table-striped table-bordered table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" class="text-center">Product</th>
                                <th scope="col" class="text-center">Price</th>
                                <th scope="col" class="text-center">Taxes</th>
                                <th scope="col" class="text-center">Quantity Type</th>
                            </tr>
                        </thead>
                        <tbody class="">
                            <tr v-for='c in cart'>
                                <td class="text-center">{{ c.product_name }}</td>
                                <td class="text-center">R$ {{ c.product_price }}</td>
                                <td class="text-center">R$ {{ c.product_taxes }}</td>
                                <td class="text-center">{{ c.product_quantity }}</td>
                            </tr>
                            <tr>
                                <th scope="col" class="text-center"></th>
                                <th scope="col" class="text-center"></th>
                                <th scope="col" class="text-center">Total price</th>
                                <th scope="col" class="text-center">Total Taxes</th>
                            </tr>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center">R$ {{ total_price }}</td>
                            <td class="text-center">R$ {{ tax_amount }}</td>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col">
                    <h1>Sales</h1>
                    <table class="table table-striped table-bordered table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Total price</th>
                                <th class="text-center">Tax amount</th>
                                <th class="text-center">Status</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="sale in sales">
                                <td class="text-center">{{sale.id}}</td>
                                <td class="text-center">R${{sale.total_price}}</td>
                                <td class="text-center">R${{sale.tax_amount}}</td>
                                <td class="text-center">{{sale.id_status}}</td>
                                <td class="text-center"><button class="btn btn-danger btn-sm"
                                        v-on:click="deleteSale(sale.id)">Delete</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</body>
<script>
var app = new Vue({
    el: '#vueapp',
    data: {
        name: '',
        products: [],
        sales: [],
        product_id: [],
        products_type: [],
        message: '',
        cart: [],
        quantity: '',
        total_price: parseFloat(0),
        tax_amount: parseFloat(0),
        productTax: parseFloat(0),
        productPrice: parseFloat(0),
    },
    mounted: function() {
        this.getProducts()
        this.getSales()
    },
    methods: {
        addToCart(e) {
            if (!Number.isInteger(app.product_id) || app.quantity == "") {
                app.setMessage("Please, choose products and quantity")
            }

            if (app.product_id && Number.isInteger(app.product_id)) {
                app.productTax = app.products.filter(x => x.id === app.product_id)[0].taxes
                app.productPrice = app.products.filter(x => x.id === app.product_id)[0].price

                app.cart.push({
                    id_products: app.products.filter(x => x.id === app.product_id)[0].id,
                    product_name: app.products.filter(x => x.id === app.product_id)[0].name,
                    product_price: app.productPrice,
                    product_taxes: app.sumTaxesProduct(parseFloat(app.productTax), parseFloat(app
                        .productPrice)),
                    product_quantity: app.quantity,
                })
                app.sumPricesCart(app.products.filter(x => x.id === app.product_id)[0].price, app.quantity)
                app.sumTaxesCart(app.sumTaxesProduct(parseFloat(app.productTax), parseFloat(app.productPrice)))
            }

            app.resetForm()
        },
        sumPricesCart: function(new_price, quantity) {
            app.total_price = parseFloat(app.total_price) + (parseFloat(new_price) * parseFloat(quantity))
        },

        sumTaxesCart: function(tax) {
            var value = parseFloat(app.tax_amount) + parseFloat(tax)
            app.tax_amount = value.toFixed(2)
        },

        sumTaxesProduct: function(taxes, productPrice) {
            var value = (parseFloat(productPrice) * (parseFloat(taxes)) / 100)
            return value.toFixed(2)
        },

        getProducts: function() {
            axios.get('axios.php?getProducts=true&getTaxes=true')
                .then(function(response) {
                    app.products = response.data;
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        getSales: function() {
            axios.get('axios.php?getSales=true')
                .then(function(response) {
                    app.sales = response.data;
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        deleteSale: function(id) {
            let formData = new FormData();
            formData.set('id', id)
            formData.set('delete-sale', true)
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
        newSale: function() {
            let formData = new FormData();
            formData.set('total_price', app.total_price)
            formData.set('tax_amount', app.tax_amount)
            formData.set('quantity', app.quantity)
            formData.set('id_status', 1)
            formData.set('productsale[]', app.prepareData())
            formData.set('newSale', true)
            formData.set('id', "")
            var sale = {};
            formData.forEach(function(value, key) {
                sale[key] = value;
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
                        sale.id = response.data.lastId
                        app.sales.push(sale)
                        app.setMessage("Ok")
                        app.resetForm();
                    } else {
                        app.setMessage(response.data.error)
                        console.log(response.data)
                    }
                })
                .catch(function(response) {
                    console.log(response.data)
                });
        },
        resetForm: function() {
            this.name = '';
            this.quantity = 1;
        },
        setMessage: function(msg) {
            app.message = msg;
            setTimeout(function() {
                app.message = "";
            }, 2000);
        },
        prepareData() {
            var productSaleArr = []
            app.cart.forEach(function(index) {
                productSaleArr.push({
                    id_products: index.id_products,
                    product_name: index.product_name,
                    product_price: index.product_price,
                    product_taxes: index.product_taxes,
                    product_quantity: index.product_quantity,
                })
            })
            return JSON.stringify(productSaleArr)
        },
    }
})
</script>

</html>