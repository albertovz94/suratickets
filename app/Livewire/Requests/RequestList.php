<?php

namespace App\Livewire\Requests;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Request;
use App\Models\RequestComment;
use Illuminate\Support\Facades\Storage;

class RequestList extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $activeTab = 'pendiente'; // Tabs: pendiente, en_proceso, entregado, rechazado

    // Propiedades para los modales de acción
    public $actionModalVisible = false;
    public $selectedRequestId = null;
    public $pendingAction = null; // 'aprobar', 'rechazar', 'entregar'
    public $adminNote = '';
    public $deliveryNote = '';
    public $proofPhoto = null;

    // Propiedades para el modal de detalle / timeline
    public $detailModalVisible = false;
    public $selectedRequest = null;
    public $newCommentBody = '';

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage(); // Volver a la primera página al cambiar de pestaña
    }

    public function openActionModal($id, $action)
    {
        if (!auth()->user()->hasAdminAccess()) {
            abort(403);
        }

        $this->selectedRequestId = $id;
        $this->pendingAction = $action;
        $this->adminNote = '';
        $this->deliveryNote = '';
        $this->proofPhoto = null;
        $this->actionModalVisible = true;
    }

    public function closeActionModal()
    {
        $this->actionModalVisible = false;
        $this->selectedRequestId = null;
        $this->pendingAction = null;
        $this->adminNote = '';
        $this->deliveryNote = '';
        $this->proofPhoto = null;
    }

    public function confirmAction()
    {
        if (!auth()->user()->hasAdminAccess()) {
            abort(403);
        }

        // Validación condicional dependiendo de la acción
        $rules = [];
        if ($this->pendingAction === 'aprobar' || $this->pendingAction === 'rechazar') {
            $rules['adminNote'] = 'nullable|string|max:1000';
        } elseif ($this->pendingAction === 'entregar') {
            $rules['proofPhoto'] = 'required|image|max:5120'; // Obligatoria (máx 5MB)
            $rules['deliveryNote'] = 'nullable|string|max:1000';
        }

        if (!empty($rules)) {
            $this->validate($rules);
        }

        $solicitud = Request::findOrFail($this->selectedRequestId);
        $newStatus = '';

        if ($this->pendingAction === 'aprobar') {
            $newStatus = 'en_proceso';
            $solicitud->admin_note = $this->adminNote;
        } elseif ($this->pendingAction === 'rechazar') {
            $newStatus = 'rechazado';
            $solicitud->admin_note = $this->adminNote;
        } elseif ($this->pendingAction === 'entregar') {
            $newStatus = 'entregado';
            
            if ($this->proofPhoto) {
                // Guardar la foto en el storage publico, carpeta 'proofs'
                $path = $this->proofPhoto->store('proofs', 'public');
                $solicitud->proof_photo_path = $path;
            }
            $solicitud->delivery_note = $this->deliveryNote;
            $solicitud->delivered_at = now();
        }

        $solicitud->status = $newStatus;
        $solicitud->save();
        
        $this->dispatch('notify', message: "Solicitud #{$solicitud->id} actualizada a '{$newStatus}'.");
        
        $this->closeActionModal();
    }

    public function openDetailModal($id)
    {
        $this->selectedRequest = Request::with(['user', 'assignedTo', 'comments.user'])->findOrFail($id);
        $this->newCommentBody = ''; // Resetear campo de comentario al abrir
        $this->detailModalVisible = true;
    }

    public function closeDetailModal()
    {
        $this->detailModalVisible = false;
        $this->selectedRequest = null;
        $this->newCommentBody = '';
    }

    public function addComment()
    {
        if (!$this->selectedRequest) return;

        // Validaciones de seguridad
        $user = auth()->user();
        $isAdmin = $user->hasAdminAccess();
        
        // Condiciones para poder comentar:
        // 1. Debe estar 'en_proceso' (opcional, pero sugerido).
        // 2. Si NO es admin, debe haber pasado 15 días o ya haber comentarios en el hilo.
        if (!$isAdmin) {
            $daysSinceCreation = $this->selectedRequest->created_at->diffInDays(now());
            $hasComments = $this->selectedRequest->comments->count() > 0;
            
            if ($daysSinceCreation < 15 && !$hasComments) {
                // No tiene permiso aún
                session()->flash('error', 'Aún no puedes agregar notas a esta solicitud.');
                return;
            }
        }

        $this->validate([
            'newCommentBody' => 'required|string|max:1000'
        ]);

        RequestComment::create([
            'request_id' => $this->selectedRequest->id,
            'user_id' => $user->id,
            'body' => $this->newCommentBody,
        ]);

        $this->newCommentBody = '';
        // Recargar la solicitud para obtener los comentarios frescos
        $this->selectedRequest = Request::with(['user', 'assignedTo', 'comments.user'])->findOrFail($this->selectedRequest->id);
    }

    public function render()
    {
        $query = Request::query();

        // Filtrar por la pestaña activa
        $query->where('status', $this->activeTab);

        if (auth()->user()->hasAdminAccess()) {
            $solicitudes = $query->with('user', 'assignedTo')->latest()->paginate(15);
        } else {
            $solicitudes = $query->where('user_id', auth()->id())->with('user', 'assignedTo')->latest()->paginate(15);
        }

        return view('livewire.requests.request-list', [
            'solicitudes' => $solicitudes
        ])->layout('layouts.app');
    }
}
