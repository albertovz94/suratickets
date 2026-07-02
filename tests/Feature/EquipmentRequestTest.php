<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;
use App\Models\User;
use App\Models\Branch;
use App\Models\Department;
use App\Models\EquipmentRequest;
use App\Livewire\Requests\RequestForm;
use App\Livewire\Requests\RequestList;

class EquipmentRequestTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private User $outsourcingAdmin;
    private Branch $branch;
    private Department $department;

    protected function setUp(): void
    {
        parent::setUp();

        $this->branch = Branch::factory()->create(['is_active' => true]);
        $this->department = Department::factory()->create();
        
        $this->user = User::factory()->create([
            'role' => 'usuario',
            'branch_id' => $this->branch->id,
            'department_id' => $this->department->id,
        ]);

        $this->outsourcingAdmin = User::factory()->create([
            'role' => 'outsourcing',
            'branch_id' => $this->branch->id,
            'department_id' => $this->department->id,
        ]);
    }

    public function test_request_list_page_can_be_rendered()
    {
        $response = $this->actingAs($this->user)->get(route('requests.index'));
        $response->assertStatus(200);
    }

    public function test_can_navigate_wizard_steps_and_create_request()
    {
        Livewire::actingAs($this->user)
            ->test(RequestForm::class)
            // Step 1 validation failure
            ->set('device_type', '')
            ->set('urgency', 'baja')
            ->call('nextStep')
            ->assertHasErrors(['device_type' => 'required'])
            ->assertSet('step', 1)

            // Step 1 success
            ->set('device_type', 'Laptop Pro')
            ->set('urgency', 'alta')
            ->call('nextStep')
            ->assertHasNoErrors()
            ->assertSet('step', 2)

            // Step 2 validation failure
            ->set('assigned_to', null)
            ->call('nextStep')
            ->assertHasErrors(['assigned_to' => 'required'])
            ->assertSet('step', 2)

            // Step 2 success
            ->set('assigned_to', $this->outsourcingAdmin->id)
            ->call('nextStep')
            ->assertHasNoErrors()
            ->assertSet('step', 3)

            // Step 3 validation failure
            ->set('description', 'Corta')
            ->call('save')
            ->assertHasErrors(['description' => 'min'])

            // Step 3 success and redirect
            ->set('description', 'Necesito una laptop de mayor rendimiento para compilar aplicaciones.')
            ->call('save')
            ->assertRedirect(route('requests.index'));

        $this->assertDatabaseHas('equipment_requests', [
            'user_id' => $this->user->id,
            'device_type' => 'Laptop Pro',
            'urgency' => 'alta',
            'assigned_to' => $this->outsourcingAdmin->id,
            'description' => 'Necesito una laptop de mayor rendimiento para compilar aplicaciones.',
            'status' => 'pendiente',
        ]);
    }

    public function test_admin_can_approve_or_reject_requests()
    {
        $request = EquipmentRequest::create([
            'user_id' => $this->user->id,
            'device_type' => 'Monitor 4K',
            'urgency' => 'media',
            'assigned_to' => $this->outsourcingAdmin->id,
            'description' => 'Para diseño gráfico en la sucursal.',
            'status' => 'pendiente',
        ]);

        $admin = User::factory()->create([
            'role' => 'admin',
            'branch_id' => $this->branch->id,
            'department_id' => $this->department->id,
        ]);

        Livewire::actingAs($admin)
            ->test(RequestList::class)
            ->call('openActionModal', $request->id, 'aprobar')
            ->assertSet('requestIdSometidoAAccion', $request->id)
            ->assertSet('accionSolicitada', 'aprobar')
            ->call('procesarAccion')
            ->assertSet('requestIdSometidoAAccion', null);

        $request->refresh();
        $this->assertEquals('en_proceso', $request->status);
    }
}
