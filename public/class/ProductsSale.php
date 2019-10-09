<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'Crud.php';
class ProductsSale extends Crud
{
    protected $table = 'product_sale';

    private $id;
    private $name;
    private $taxes;
    private $quantity;
    private $id_sales;
    private $id_products;

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of taxes
     */
    public function getTaxes()
    {
        return $this->taxes;
    }

    /**
     * Set the value of taxes
     *
     * @return  self
     */
    public function setTaxes($taxes)
    {
        $this->taxes = $taxes;

        return $this;
    }

    /**
     * Get the value of quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get the value of id_sales
     */
    public function getId_sales()
    {
        return $this->id_sales;
    }

    /**
     * Set the value of id_sales
     *
     * @return  self
     */
    public function setId_sales($id_sales)
    {
        $this->id_sales = $id_sales;

        return $this;
    }

    /**
     * Get the value of id_products
     */
    public function getId_products()
    {
        return $this->id_products;
    }

    /**
     * Set the value of id_products
     *
     * @return  self
     */
    public function setId_products($id_products)
    {
        $this->id_products = $id_products;

        return $this;
    }

    public function insert()
    {
        $sql = "INSERT INTO $this->table (name, taxes, quantity, id_sales, id_products) VALUES (:name, :taxes, :quantity, :id_sales, :id_products)";
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':taxes', $this->taxes);
        $stmt->bindParam(':quantity', $this->quantity);
        $stmt->bindParam(':id_sales', $this->id_sales);
        $stmt->bindParam(':id_products', $this->id_products);
        return $stmt->execute();
    }

    public function update($id)
    {
        $sql = "UPDATE $this->table
                SET name = :name,
                    taxes = :taxes,
                    quantity = :quantity,
                    id_sales = :id_sales,
                    id_products = :id_products
                WHERE id = :id";
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':taxes', $this->taxes);
        $stmt->bindParam(':quantity', $this->quantity);
        $stmt->bindParam(':id_sales', $this->id_sales);
        $stmt->bindParam(':id_products', $this->id_products);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
