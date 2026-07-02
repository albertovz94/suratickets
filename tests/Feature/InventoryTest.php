<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;
use App\Models\User;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Device;
use App\Livewire\Inventory\InventoryList;
use App\Livewire\Inventory\InventoryForm;

class InventoryTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Branch $branch;
    private Department $department;

    protected function setUp(): void
    {
        parent::setUp();

        $this->branch = Branch::factory()->create(['is_active' => true]);
        $this->department = Department::factory()->create();
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'branch_id' => $this->branch->id,
            'department_id' => $this->department->id,
        ]);
    }

    public function test_inventory_list_page_can_be_rendered()
    {
        $response = $this->actingAs($this->admin)->get(route('inventory.index'));
        $response->assertStatus(200);
    }

    public function test_can_search_and_filter_devices_in_inventory()
    {
        $device1 = Device::factory()->create([
            'name' => 'Laptop de Desarrollo',
            'type' => 'Laptop',
            'status' => 'Activo',
            'branch_id' => $this->branch->id,
            'department_id' => $this->department->id,
            'serial_number' => 'SN123456789'
        ]);

        $device2 = Device::factory()->create([
            'name' => 'Servidor BD',
            'type' => 'Servidor',
            'status' => 'En reparacion',
            'branch_id' => $this->branch->id,
            'department_id' => $this->department->id,
            'serial_number' => 'SN987654321'
        ]);

        Livewire::actingAs($this->admin)
            ->test(InventoryList::class)
            ->set('search', 'Desarrollo')
            ->assertSee($device1->name)
            ->assertDontSee($device2->name);

        Livewire::actingAs($this->admin)
            ->test(InventoryList::class)
            ->set('type', 'Servidor')
            ->assertSee($device2->name)
            ->assertDontSee($device1->name);
    }

    public function test_can_create_a_device()
    {
        Livewire::actingAs($this->admin)
            ->test(InventoryForm::class)
            ->set('name', 'Nuevo Desktop IT')
            ->set('specs', 'Intel i7, 16GB RAM')
            ->set('type', 'Desktop')
            ->set('serial_number', 'SN-NEW-999')
            ->set('branch_id', $this->branch->id)
            ->set('department_id', $this->department->id)
            ->set('status', 'Activo')
            ->call('save')
            ->assertRedirect(route('inventory.index'));

        $this->assertDatabaseHas('devices', [
            'name' => 'Nuevo Desktop IT',
            'serial_number' => 'SN-NEW-999',
            'type' => 'Desktop',
            'status' => 'Activo'
        ]);
    }

    public function test_can_delete_a_device_with_modal()
    {
        $device = Device::factory()->create([
            'name' => 'Laptop para Desecho',
            'type' => 'Laptop',
            'status' => 'De baja',
            'branch_id' => $this->branch->id,
            'department_id' => $this->department->id,
            'serial_number' => 'SN-TRASH-123'
        ]);

        Livewire::actingAs($this->admin)
            ->test(InventoryList::class)
            ->call('confirmDeleteEquipo', $device->id)
            ->assertSet('equipoIdSometidoAEliminacion', $device->id)
            ->call('deleteEquipo')
            ->assertSet('equipoIdSometidoAEliminacion', null);

        $this->assertSoftDeleted('devices', [
            'id' => $device->id
        ]);
    }
}
