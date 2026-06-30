<?php

namespace App\Enums;

enum UserStatus: string
{
    case ACTIVO = 'Activo';
    case BLOQUEADA = 'Bloqueada';
    case INACTIVO = 'Inactivo';

    public function label(): string
    {
        return $this->value;
    }
}
