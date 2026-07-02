<?php

namespace App\DTOs;

class TicketDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly ?string $category = null,
        public readonly ?int $deviceId = null,
        public readonly ?string $attachmentPath = null,
        public readonly ?int $creatorId = null,
        public readonly ?int $assignedTo = null,
        public readonly ?string $status = null,
        public readonly ?string $priority = null
    ) {}

    /**
     * Create a DTO instance from a raw array.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            description: $data['description'],
            category: $data['category'] ?? null,
            deviceId: isset($data['device_id']) && $data['device_id'] !== '' ? (int) $data['device_id'] : null,
            attachmentPath: $data['attachment_path'] ?? null,
            creatorId: isset($data['creator_id']) && $data['creator_id'] !== '' ? (int) $data['creator_id'] : (isset($data['user_id']) ? (int) $data['user_id'] : null),
            assignedTo: isset($data['assigned_to']) && $data['assigned_to'] !== '' ? (int) $data['assigned_to'] : null,
            status: $data['status'] ?? null,
            priority: $data['priority'] ?? null
        );
    }

    /**
     * Convert DTO back to a database-ready array representation.
     */
    public function toDatabaseArray(): array
    {
        return array_filter([
            'title' => $this->title,
            'description' => $this->description,
            'category' => $this->category,
            'device_id' => $this->deviceId,
            'attachment_path' => $this->attachmentPath,
            'creator_id' => $this->creatorId,
            'assigned_to' => $this->assignedTo,
            'status' => $this->status,
            'priority' => $this->priority,
        ], fn($value) => $value !== null);
    }
}
