<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'Crud.php';
class Sales extends Crud
{
    protected $table = 'sales';

    private $id;
    private $total_price;
    private $tax_amount;
    private $id_status;

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
     * Get the value of total_price
     */ 
    public function getTotal_price()
    {
        return $this->total_price;
    }

    /**
     * Set the value of total_price
     *
     * @return  self
     */ 
    public function setTotal_price($total_price)
    {
        $this->total_price = $total_price;

        return $this;
    }

    /**
     * Get the value of tax_amount
     */ 
    public function getTax_amount()
    {
        return $this->tax_amount;
    }

    /**
     * Set the value of tax_amount
     *
     * @return  self
     */ 
    public function setTax_amount($tax_amount)
    {
        $this->tax_amount = $tax_amount;

        return $this;
    }

    /**
     * Get the value of id_status
     */ 
    public function getId_status()
    {
        return $this->id_status;
    }

    /**
     * Set the value of id_status
     *
     * @return  self
     */ 
    public function setId_status($id_status)
    {
        $this->id_status = $id_status;

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

    public function insert()
    {
        $sql = "INSERT INTO $this->table (total_price, tax_amount, id_status) VALUES (:total_price, :tax_amount, :id_status)";
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':total_price', $this->total_price);
        $stmt->bindParam(':tax_amount', $this->tax_amount);
        $stmt->bindParam(':id_status', $this->id_status);
        return $stmt->execute();
    }

    public function update($id)
    {
        $sql = "UPDATE $this->table
                SET id = :id,
                    total_price = :total_price,
                    tax_amount = :tax_amount,
                    id_status = :id_status
                WHERE id = :id";
        $stmt = DB::prepare($sql);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':total_price', $this->total_price);
        $stmt->bindParam(':tax_amount', $this->tax_amount);
        $stmt->bindParam(':id_status', $this->id_status);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
