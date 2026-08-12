<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Todos pueden ver la lista (filtrada en la query)
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ticket $ticket): bool
    {
        // Administradores y personal de outsourcing siempre tienen acceso
        if ($user->hasAdminAccess()) {
            return true;
        }

        // Permitir si es el creador del ticket (comparación no estricta para evitar fallo por int vs string)
        if ((int)$user->id === (int)$ticket->creator_id) {
            return true;
        }

        // Permitir si el técnico o usuario está asignado al ticket
        if ($ticket->assigned_to && (int)$user->id === (int)$ticket->assigned_to) {
            return true;
        }

        // Permitir si pertenece al mismo departamento o sucursal del ticket
        if ($user->department_id && (int)$user->department_id === (int)$ticket->department_id) {
            return true;
        }

        if ($user->branch_id && (int)$user->branch_id === (int)$ticket->branch_id) {
            return true;
        }

        // Denegar acceso si no cumple ninguna de las condiciones anteriores
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Cualquier usuario autenticado puede crear
    }

    /**
     * Determine whether the user can update the model (estado, asignación).
     */
    public function update(User $user, Ticket $ticket): bool
    {
        return $user->hasAdminAccess();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->hasAdminAccess();
    }
}
