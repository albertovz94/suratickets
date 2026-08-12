<?php

namespace App\Services;

use App\Models\Ticket;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    /**
     * Envía notificación a Telegram sobre un ticket
     */
    public static function sendTicketNotification(Ticket $ticket, string $type = 'created')
    {
        $botToken = env('TELEGRAM_BOT_TOKEN', '8646858864:AAHrnNtBw19jjupBJNjewZmsSBAYxxwf1wQ');
        $chatId = env('TELEGRAM_CHAT_ID', '-5035415559');

        if (!$botToken || !$chatId) {
            return;
        }

        $appUrl = config('app.url', 'https://sistemassuraki.suraki.net');
        $ticketUrl = rtrim($appUrl, '/') . '/tickets';

        $branch = $ticket->sucursal->nombre ?? 'N/A';
        $department = $ticket->area_departamento ?? 'N/A';
        $device = $ticket->equipo_afectado ?? 'No especificado';
        $creator = $ticket->creator->name ?? 'Usuario';
        $technician = $ticket->assignedTo->name ?? 'Sin asignar';

        $priorityEmoji = match($ticket->priority) {
            'critica' => '🚨🔥 CRÍTICA',
            'alta' => '🔴 ALTA',
            'media' => '🟡 MEDIA',
            default => '🟢 BAJA',
        };

        if ($type === 'created') {
            $title = "🎫 <b>NUEVO TICKET REQUERIDO #{$ticket->id}</b>";
            $statusText = "Abierto";
        } elseif ($type === 'resolved') {
            $title = "✅ <b>TICKET RESUELTO #{$ticket->id}</b>";
            $statusText = "Resuelto";
        } else {
            $title = "🔄 <b>TICKET ACTUALIZADO #{$ticket->id}</b>";
            $statusText = ucfirst(str_replace('_', ' ', $ticket->status));
        }

        $message = "{$title}\n\n";
        $message .= "🏢 <b>Sucursal:</b> {$branch}\n";
        $message .= "📍 <b>Área / Depto:</b> {$department}\n";
        $message .= "💻 <b>Equipo Afectado:</b> {$device}\n";
        $message .= "⚡ <b>Prioridad:</b> {$priorityEmoji}\n";
        $message .= "👤 <b>Reportado por:</b> {$creator}\n";
        $message .= "🛠 <b>Técnico Asignado:</b> {$technician}\n";
        $message .= "📌 <b>Estado:</b> {$statusText}\n\n";
        $message .= "📝 <b>Detalle del Asunto:</b> {$ticket->title}\n";
        if ($ticket->description) {
            $message .= "<i>\"" . htmlspecialchars(mb_strimwidth($ticket->description, 0, 300, "...")) . "\"</i>\n\n";
        }
        $message .= "🔗 <a href=\"{$ticketUrl}\">Ingresar al sistema para resolver</a>";

        try {
            Http::post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
                'disable_web_page_preview' => false,
            ]);
        } catch (\Exception $e) {
            Log::error("Error enviando notificación a Telegram: " . $e->getMessage());
        }
    }
}
