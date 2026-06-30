<?php

namespace App\Enums;

enum TicketStatus: string
{
    case ABIERTO = 'abierto';
    case ASIGNADO = 'asignado';
    case EN_PROCESO = 'en_proceso';
    case PENDIENTE = 'pendiente';
    case RESUELTO = 'resuelto';
    case CERRADO = 'cerrado';

    public function label(): string
    {
        return match ($this) {
            self::ABIERTO => 'Abierto',
            self::ASIGNADO => 'Asignado',
            self::EN_PROCESO => 'En Proceso',
            self::PENDIENTE => 'Pendiente',
            self::RESUELTO => 'Resuelto',
            self::CERRADO => 'Cerrado',
        };
    }
}
