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
        $botToken = env('TELEGRAM_BOT_TOKEN', '8732518099:AAFDcVJidoESQCx46ykwpOVRuFcXUkVZG2Q');
        $chatId = env('TELEGRAM_CHAT_ID');

        if (!$botToken || !$chatId) {
            return;
        }

        $appUrl = config('app.url', 'https://sistemassuraki.suraki.net');
        $ticketUrl = rtrim($appUrl, '/') . '/tickets';

        $sucursal = $ticket->sucursal->nombre ?? 'N/A';
        $area = $ticket->area_departamento ?? 'N/A';
        $equipo = $ticket->equipo_afectado ?? 'No especificado';
        $creador = $ticket->creator->name ?? 'Usuario';
        $tecnico = $ticket->assignedTo->name ?? 'Sin asignar';

        $emojiPrioridad = match($ticket->priority) {
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
        $message .= "🏢 <b>Sucursal:</b> {$sucursal}\n";
        $message .= "📍 <b>Área / Depto:</b> {$area}\n";
        $message .= "💻 <b>Equipo Afectado:</b> {$equipo}\n";
        $message .= "⚡ <b>Prioridad:</b> {$emojiPrioridad}\n";
        $message .= "👤 <b>Reportado por:</b> {$creador}\n";
        $message .= "🛠 <b>Técnico Asignado:</b> {$tecnico}\n";
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
