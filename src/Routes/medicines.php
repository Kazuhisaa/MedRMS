<?php
use Slim\App;
use App\Controllers\MedicineController;
use Slim\Routing\RouteCollectorProxy;

return function (App $app) {
    $controller = new MedicineController();
$app->group('/medicines', function (RouteCollectorProxy $group) {
$group->get('', [MedicineController::class, 'index']);      // GET all medicines
$group->get('/{id}', [MedicineController::class, 'show']);  // GET medicine by id
$group->post('', [MedicineController::class, 'store']);     // POST new medicine
$group->put('/{id}', [MedicineController::class, 'update']); // PUT update medicine
$group->delete('/{id}', [MedicineController::class, 'delete']); // DELETE medicine

});


};
