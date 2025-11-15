<?php
namespace App\Repositories;

use App\Config\Database;
use App\Models\Medicine;
use PDO;

class MedicineRepository {

    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    // Fetch all medicines
    public function getAll() {
    $stmt = $this->conn->prepare("SELECT * FROM medicines WHERE deleted_at IS NULL");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);


        $medicines = [];
        foreach ($rows as $row) {
            $medicines[] = new Medicine($row);
        }
        return $medicines;
    }

    // Find medicine by ID
    public function findById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM medicines WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new Medicine($row) : null;
    }

    // Insert new medicine
    public function insert(Medicine $medicine) {
        $stmt = $this->conn->prepare("
            INSERT INTO medicines (name, brand, category, form, description, dosage, note, stock, image, expiry_date, suppliers, date_added)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $medicine->name,
            $medicine->brand,
            $medicine->category,
            $medicine->form,
            $medicine->description,
            $medicine->dosage,
            $medicine->note,
            $medicine->stock,
            $medicine->image,
            $medicine->expiry_date,
            $medicine->suppliers,
            $medicine->date_added
        ]);
    }

    // Update existing medicine
    public function update(Medicine $medicine) {
        $stmt = $this->conn->prepare("
            UPDATE medicines SET
                name = ?, brand = ?, category = ?, form = ?, description = ?, dosage = ?, note = ?, stock = ?, image = ?, expiry_date = ?, suppliers = ?, date_added = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $medicine->name,
            $medicine->brand,
            $medicine->category,
            $medicine->form,
            $medicine->description,
            $medicine->dosage,
            $medicine->note,
            $medicine->stock,
            $medicine->image,
            $medicine->expiry_date,
            $medicine->suppliers,
            $medicine->date_added,
            $medicine->id
        ]);
    }

    //Rrchive
    public function delete($id) {
        $stmt = $this->conn->prepare("UPDATE medicines SET deleted_at = NOW() WHERE id = ?");
        return $stmt->execute([$id]);
    }
    // Restore medicine by ID
    public function restore($id) {
        $stmt = $this->conn->prepare("UPDATE medicines SET deleted_at = NULL WHERE id = ?");
        return $stmt->execute([$id]);
    }


}
