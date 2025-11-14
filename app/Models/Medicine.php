<?php 

namespace App\Models;

class Medicine{

    public $id;
    public $name;
    public $brand;
    public $category;
    public $form;
    public $description;
    public $dosage;
    public $note;
    public $stock;
    public $image;
    public $expiry_date;
    public $suppliers;
    public $date_added;

 public function __construct($data = []) {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'] ?? '';
        $this->brand = $data['brand'] ?? '';
        $this->form = $data['form'] ?? '';
        $this->category = $data['category'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->dosage = $data['dosage'] ?? '';
        $this->note = $data['note'] ?? '';
        $this->stock = $data['stock'] ?? 0;
        $this->image = $data['image'] ?? '';
        $this->expiry_date = $data['expiry_date'] ?? null;
        $this->suppliers = $data['suppliers'] ?? null;
        $this->date_added = $data['date_added'] ?? null;




 }
}



?>