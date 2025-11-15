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
        $stmt = $this->conn->query("SELECT * FROM medicines ORDER BY name");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

    // Delete medicine by ID
    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM medicines WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
