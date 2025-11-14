<?php
namespace App\Services;

use App\Repositories\MedicineRepository;
use App\Models\Medicine;

class MedicineService {
    private $repo;

    public function __construct() {
        $this->repo = new MedicineRepository();
    }

    // Get all medicines
    public function getAllMedicines() {
        return $this->repo->getAll();
    }

    // Find medicine by ID
    public function getMedicineById($id) {
        return $this->repo->findById($id);
    }

    // Add new medicine with basic validation
    public function addMedicine(Medicine $medicine) {
        if (empty($medicine->name) || $medicine->stock < 0) {
            throw new \Exception("Invalid medicine data");
        }
        return $this->repo->insert($medicine);
    }

    // Update medicine with validation
    public function updateMedicine(Medicine $medicine) {
        if (empty($medicine->name) || $medicine->stock < 0) {
            throw new \Exception("Invalid medicine data");
        }
        return $this->repo->update($medicine);
    }

    // Delete medicine
    public function deleteMedicine($id) {
        return $this->repo->delete($id);
    }

    // Example: check if stock is enough
    public function checkStock($medicineId, $quantity) {
        $med = $this->repo->findById($medicineId);
        if (!$med) return false;
        return $med->stock >= $quantity;
    }
}
