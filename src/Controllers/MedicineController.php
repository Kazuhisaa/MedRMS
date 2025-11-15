<?php
namespace App\Controllers;

use App\Services\MedicineService;

class MedicineController {
    private $service;

    public function __construct() {
        $this->service = new MedicineService();
    }

    // GET /api/medicines
    public function getAll() {
        header('Content-Type: application/json');
        $medicines = $this->service->getAllMedicines();

        // Convert each Medicine object to array
        $data = array_map(fn($med) => (array)$med, $medicines);

        echo json_encode($data);
    }

    // GET /api/medicines/{id}
    public function getById($id) {
        header('Content-Type: application/json');
        $med = $this->service->getMedicineById($id);
        if ($med) {
            echo json_encode((array)$med);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Medicine not found']);
        }
    }

    // POST /api/medicines
    public function create($postData) {
        header('Content-Type: application/json');
        try {
            $med = new \App\Models\Medicine($postData);
            $this->service->addMedicine($med);
            echo json_encode(['success' => true]);
        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // DELETE /api/medicines/{id}
    public function delete($id) {
        header('Content-Type: application/json');
        $this->service->deleteMedicine($id);
        echo json_encode(['success' => true]);
    }
}
    