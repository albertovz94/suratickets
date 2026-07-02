<?php

namespace App\Actions\Requests;

use App\Models\EquipmentRequest;
use App\DTOs\EquipmentRequestDTO;

class CreateEquipmentRequestAction
{
    /**
     * Executes the creation of an EquipmentRequest.
     *
     * @param EquipmentRequestDTO $dto
     * @return EquipmentRequest
     */
    public function execute(EquipmentRequestDTO $dto): EquipmentRequest
    {
        // Se puede añadir cualquier lógica de negocio extra aquí (por ejemplo, notificar a los admins)
        return EquipmentRequest::create($dto->toDatabaseArray());
    }
}
