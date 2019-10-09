<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'Crud.php';
class ProductsType extends Crud
{
    protected $table = 'products_type';
    private $id;
    private $name;
    private $taxes;
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
        if (empty($name)) {
            echo json_encode(array("status" => "0", "error" => "Name: Invalid value Null"));
            exit;   
        }  
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
        if (!is_numeric($taxes)) {
            echo json_encode(array("status" => "0", "error" => "Taxes: Invalid value " . (empty($taxes) ? "Null" : $taxes)));
            exit;   
        }   
        $this->taxes = $taxes;
        return $this;
    }
    public function insert()
    {
        $sql = "INSERT INTO $this->table (name, taxes) VALUES (:name, :taxes)";
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':taxes', $this->taxes);
        return $stmt->execute();
    }
    public function update($id)
    {
        $sql = "UPDATE $this->table
                SET name = :name,
                    taxes = :taxes,
                WHERE id = :id";
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':taxes', $this->taxes);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
