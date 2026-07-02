<?php

namespace App\DTOs;

class EquipmentRequestDTO
{
    public function __construct(
        public readonly int $userId,
        public readonly string $deviceType,
        public readonly string $urgency,
        public readonly ?int $assignedTo,
        public readonly string $description,
        public readonly ?string $status = 'pendiente'
    ) {}

    /**
     * Create a DTO instance from a raw array.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            userId: (int) ($data['user_id'] ?? auth()->id()),
            deviceType: $data['device_type'],
            urgency: $data['urgency'],
            assignedTo: isset($data['assigned_to']) && $data['assigned_to'] !== '' ? (int) $data['assigned_to'] : null,
            description: $data['description'],
            status: $data['status'] ?? 'pendiente'
        );
    }

    /**
     * Convert DTO back to a database-ready array representation.
     */
    public function toDatabaseArray(): array
    {
        return [
            'user_id' => $this->userId,
            'device_type' => $this->deviceType,
            'urgency' => $this->urgency,
            'assigned_to' => $this->assignedTo,
            'description' => $this->description,
            'status' => $this->status,
        ];
    }
}
