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
        
        // Auto-detectar Prioridad y Categoría si no vienen especificados o si vienen con valores por defecto
        if (empty($payload['priority']) || $payload['priority'] === 'baja') {
            $payload['priority'] = $this->calculatePriority($dto->title, $dto->description);
        }
        
        if (empty($payload['category']) || $payload['category'] === 'otros') {
            $payload['category'] = $this->calculateCategory($dto->title, $dto->description);
        }
        
        $assignedAdmin = $this->findBestAvailableAdmin();

        if ($assignedAdmin) {
            $payload['assigned_to'] = $assignedAdmin->id;
            $payload['status'] = 'asignado';
        } else {
            $payload['status'] = 'abierto';
        }

        return Ticket::create($payload);
    }

    /**
     * Calculates the ticket priority based on text content.
     */
    private function calculatePriority(string $title, string $description): string
    {
        $textToAnalyze = mb_strtolower($title . ' ' . $description);
        
        $criticalWords = ['urgente', 'emergencia', 'incendio', 'servidor caido', 'servidor caído', 'sin sistema', 'bloqueo total', 'sin venta', 'critico', 'crítico', 'parado'];
        $highWords = ['caído', 'caido', 'sin internet', 'no enciende', 'no imprime', 'pantalla azul', 'imposible trabajar', 'virus', 'alta'];
        $lowWords = ['consulta', 'sugerencia', 'duda', 'mantenimiento', 'baja'];

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

        foreach ($lowWords as $word) {
            if (str_contains($textToAnalyze, $word)) {
                return 'baja';
            }
        }

        return 'media';
    }

    /**
     * Calculates the ticket category based on text content keywords.
     */
    private function calculateCategory(string $title, string $description): string
    {
        $textToAnalyze = mb_strtolower($title . ' ' . $description);

        $hardwareWords = ['impresora', 'impresoras', 'pantalla', 'monitor', 'mouse', 'teclado', 'laptop', 'pc', 'computadora', 'equipo', 'disco', 'ram', 'cargador', 'toner', 'tóner', 'camara', 'cámara', 'batería', 'bateria', 'ups', 'escáner', 'escaner', 'hardware', 'cpu', 'cable', 'hdmi', 'vga', 'imprimir'];
        $redesWords = ['internet', 'wifi', 'wi-fi', 'red', 'redes', 'conexion', 'conexión', 'conectar', 'cable de red', 'router', 'switch', 'ping', 'ip', 'sin internet', 'dns', 'vpn', 'navegador'];
        $softwareWords = ['sistema', 'programa', 'excel', 'word', 'windows', 'error', 'licencia', 'clave', 'contraseña', 'contrasena', 'correo', 'outlook', 'pdf', 'antivirus', 'bloqueado', 'software', 'sap', 'odoo', 'app', 'login', 'usuario'];

        foreach ($hardwareWords as $word) {
            if (str_contains($textToAnalyze, $word)) {
                return 'hardware';
            }
        }

        foreach ($redesWords as $word) {
            if (str_contains($textToAnalyze, $word)) {
                return 'redes';
            }
        }

        foreach ($softwareWords as $word) {
            if (str_contains($textToAnalyze, $word)) {
                return 'software';
            }
        }

        return 'otros';
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
