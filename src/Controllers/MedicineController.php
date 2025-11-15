<?php
namespace App\Controllers;

use App\Services\MedicineService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\Medicine;

class MedicineController {
    private $service;

    public function __construct() {
        $this->service = new MedicineService();
    }

  
    public function index(Request $request, Response $response, array $args): Response {
        $medicines = $this->service->getAllMedicines();
        $data = array_map(fn($med) => (array)$med, $medicines);

        $response->getBody()->write(json_encode($data));
        return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
    }

   
    public function show(Request $request, Response $response, array $args): Response {
        $id = $args['id'];
        $med = $this->service->getMedicineById($id);

        if ($med) {
            $response->getBody()->write(json_encode((array)$med));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } else {
            $response->getBody()->write(json_encode(['error' => 'Medicine not found']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
    }

    
    public function store(Request $request, Response $response, array $args): Response {
        $postData = $request->getParsedBody();

        try {
            $med = new Medicine($postData);
            $this->service->addMedicine($med);

            $response->getBody()->write(json_encode(['success' => true]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }


    public function update(Request $request, Response $response, array $args): Response {
        $id = $args['id'];
        $postData = $request->getParsedBody();

        try {
            $med = new Medicine($postData);
            $this->service->updateMedicine($id, $med);

            $response->getBody()->write(json_encode(['success' => true]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
    }


    public function delete(Request $request, Response $response, array $args): Response {
        $id = $args['id'];

        $this->service->deleteMedicine($id);

        $response->getBody()->write(json_encode(['success' => true]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function restore(Request $request, Response $response, array $args) {
    $id = $args['id'];

    $success = $this->service->restoreMedicine($id);

    if ($success) {
        $response->getBody()->write(json_encode(['success' => true]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    } else {
        $response->getBody()->write(json_encode(['error' => 'Restore failed']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
}

}
