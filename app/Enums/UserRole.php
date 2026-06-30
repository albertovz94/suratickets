<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case USUARIO = 'usuario';
    case OUTSOURCING = 'outsourcing';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrador',
            self::USUARIO => 'Usuario',
            self::OUTSOURCING => 'Outsourcing',
        };
    }
}
