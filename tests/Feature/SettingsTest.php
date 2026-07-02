<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;
use App\Models\User;
use App\Models\Branch;
use App\Models\Department;
use App\Livewire\Settings\SettingsList;

class SettingsTest extends TestCase
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

    public function test_settings_page_can_be_rendered()
    {
        $response = $this->actingAs($this->admin)->get(route('settings.index'));
        $response->assertStatus(200);
    }

    public function test_can_create_and_update_departments()
    {
        // Create department
        Livewire::actingAs($this->admin)
            ->test(SettingsList::class)
            ->set('department_name', 'Finanzas')
            ->call('saveDepartment')
            ->assertHasNoErrors()
            ->assertDispatched('notify');

        $this->assertDatabaseHas('departments', [
            'name' => 'Finanzas'
        ]);

        $dept = Department::where('name', 'Finanzas')->first();

        // Update department
        Livewire::actingAs($this->admin)
            ->test(SettingsList::class)
            ->set('department_id', $dept->id)
            ->set('department_name', 'Finanzas y Contabilidad')
            ->call('saveDepartment')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('departments', [
            'id' => $dept->id,
            'name' => 'Finanzas y Contabilidad'
        ]);
    }

    public function test_can_create_and_update_branches()
    {
        // Create branch
        Livewire::actingAs($this->admin)
            ->test(SettingsList::class)
            ->set('branch_name', 'Sucursal Norte')
            ->set('branch_is_active', true)
            ->call('saveBranch')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('branches', [
            'name' => 'Sucursal Norte',
            'is_active' => 1
        ]);

        $branch = Branch::where('name', 'Sucursal Norte')->first();

        // Update branch
        Livewire::actingAs($this->admin)
            ->test(SettingsList::class)
            ->set('branch_id', $branch->id)
            ->set('branch_name', 'Sucursal Norte Principal')
            ->set('branch_is_active', false)
            ->call('saveBranch')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('branches', [
            'id' => $branch->id,
            'name' => 'Sucursal Norte Principal',
            'is_active' => 0
        ]);
    }

    public function test_can_delete_empty_departments_and_branches()
    {
        $emptyDept = Department::create(['name' => 'Ventas Corporativas']);
        $emptyBranch = Branch::create(['name' => 'Sucursal Temporal', 'is_active' => true]);

        Livewire::actingAs($this->admin)
            ->test(SettingsList::class)
            ->call('deleteDepartment', $emptyDept->id)
            ->assertDispatched('notify');

        $this->assertDatabaseMissing('departments', ['id' => $emptyDept->id]);

        Livewire::actingAs($this->admin)
            ->test(SettingsList::class)
            ->call('deleteBranch', $emptyBranch->id)
            ->assertDispatched('notify');

        $this->assertDatabaseMissing('branches', ['id' => $emptyBranch->id]);
    }
}
