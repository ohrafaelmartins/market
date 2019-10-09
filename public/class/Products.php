<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'Crud.php';
class Products extends Crud
{
    protected $table = 'products';
    private $id;
    private $name;
    private $price;
    private $id_products_type;
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        if (empty($name)) {
            echo json_encode(array("status" => "0", "error" => "Name: Invalid value Null"));
            exit;
        }
        $this->name = $name;
        return $this;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function setPrice($price)
    {
        if (!is_numeric($price)) {
            echo json_encode(array("status" => "0", "error" => "Price: Invalid value " . (empty($price) ? "Null" : $price)));
            exit;
        }
        $this->price = $price;
        return $this;
    }
    public function getId_products_type()
    {
        return $this->id_products_type;
    }
    public function setId_products_type($id_products_type)
    {
        if (!is_numeric($id_products_type)) {
            echo json_encode(array("status" => "0", "error" => "Product type: Invalid value " . (empty($id_products_type) ? "Null" : $id_products_type)));
            exit;
        }
        $this->id_products_type = $id_products_type;
        return $this;
    }
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
    public function insert()
    {
        $sql = "INSERT INTO $this->table (name, price, id_products_type) VALUES (:name, :price, :id_products_type)";
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':id_products_type', $this->id_products_type);
        return $stmt->execute();
    }
    public function update($id)
    {
        $sql = "UPDATE $this->table
                SET name = :name,
                    price = :price,
                    id_products_type = :id_products_type
                WHERE id = :id";
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':id_products_type', $this->id_products_type);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function findWithTaxes($table, $rule)
    {
        $sql = "SELECT $this->table.id,
                    $this->table.name,
                    $this->table.price,
                    $table.name as name_products_type,
                    $table.id as id_products_type,
                    taxes
                FROM $this->table
                INNER JOIN $table ON $rule = $table.id";
        $stmt = DB::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
