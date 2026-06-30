<?php

namespace App\Actions\Requests;

use App\Models\EquipmentRequest;

class CreateEquipmentRequestAction
{
    /**
     * Executes the creation of an EquipmentRequest.
     *
     * @param array $data
     * @return EquipmentRequest
     */
    public function execute(array $data): EquipmentRequest
    {
        // Se puede añadir cualquier lógica de negocio extra aquí (por ejemplo, notificar a los admins)
        $request = EquipmentRequest::create([
            'user_id' => $data['user_id'],
            'device_type' => $data['device_type'],
            'urgency' => $data['urgency'],
            'assigned_to' => $data['assigned_to'],
            'description' => $data['description'],
            'status' => 'pendiente',
        ]);

        return $request;
    }
}
