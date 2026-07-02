<?php

namespace App\DTOs;

class UserDTO
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $lastName,
        public readonly string $email,
        public readonly ?string $username,
        public readonly string $role,
        public readonly string $status,
        public readonly ?int $departmentId,
        public readonly ?int $branchId,
        public readonly ?string $password,
        public readonly mixed $avatar = null
    ) {}

    /**
     * Create a DTO instance from a raw array.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            lastName: $data['last_name'] ?? null,
            email: $data['email'],
            username: $data['username'] ?? null,
            role: $data['role'],
            status: $data['status'] ?? 'Activo',
            departmentId: isset($data['department_id']) && $data['department_id'] !== '' ? (int) $data['department_id'] : null,
            branchId: isset($data['branch_id']) && $data['branch_id'] !== '' ? (int) $data['branch_id'] : null,
            password: $data['password'] ?? null,
            avatar: $data['avatar'] ?? null
        );
    }

    /**
     * Convert DTO back to a database-ready array representation.
     */
    public function toDatabaseArray(): array
    {
        return [
            'name' => $this->name,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'username' => $this->username,
            'role' => $this->role,
            'status' => $this->status,
            'department_id' => $this->departmentId,
            'branch_id' => $this->branchId,
        ];
    }
}
