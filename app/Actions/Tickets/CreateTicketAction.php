<?php

namespace App\Actions\Tickets;

use App\Models\Ticket;
use App\Models\User;
use App\DTOs\TicketDTO;

class CreateTicketAction
{
    /**
     * Executes the creation of a Ticket including auto-assignment and priority resolution.
     *
     * @param TicketDTO $dto
     * @return Ticket
     */
    public function execute(TicketDTO $dto): Ticket
    {
        $payload = $dto->toDatabaseArray();
        $payload['priority'] = $this->calculatePriority($dto->title, $dto->description);
        
        $assignedAdmin = $this->findBestAvailableAdmin();

        if ($assignedAdmin) {
            $payload['assigned_to'] = $assignedAdmin->id;
            $payload['status'] = 'asignado';
        } else {
            $payload['status'] = 'abierto';
        }

        // El TicketObserver se encargará de despachar las notificaciones
        // de 'creado' (si es crítico) o de avisar a los administradores.
        return Ticket::create($payload);
    }

    /**
     * Calculates the ticket priority based on text content.
     *
     * @param string $title
     * @param string $description
     * @return string
     */
    private function calculatePriority(string $title, string $description): string
    {
        $textToAnalyze = strtolower($title . ' ' . $description);
        
        $criticalWords = ['caído', 'caido', 'urgente', 'servidor', 'no enciende', 'internet', 'red', 'imposible', 'critico', 'crítico'];
        $highWords = ['lento', 'error', 'falla', 'pantalla azul', 'virus'];
        
        foreach ($criticalWords as $word) {
            if (str_contains($textToAnalyze, $word)) {
                return 'critica';
            }
        }
        
        foreach ($highWords as $word) {
            if (str_contains($textToAnalyze, $word)) {
                return 'alta';
            }
        }

        return 'baja';
    }

    /**
     * Finds the best active admin with the least workload.
     *
     * @return User|null
     */
    private function findBestAvailableAdmin(): ?User
    {
        $admins = User::assignableAdmins()
            ->withCount(['assignedTickets' => function ($query) {
                $query->whereIn('status', ['abierto', 'asignado', 'en_proceso', 'pendiente']);
            }])
            ->get();
            
        $workingAdmins = $admins->filter(function($admin) {
            return $admin->isWorkingNow();
        });
        
        if ($workingAdmins->count() > 0) {
            return $workingAdmins->sortBy('assigned_tickets_count')->first();
        }

        return null;
    }
}
