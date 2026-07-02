<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;
use App\Models\User;
use App\Models\Branch;
use App\Models\Department;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCredentialsMail;
use App\Livewire\Users\UserList;
use App\Livewire\Users\UserForm;

class UserListTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Branch $branch;
    private Department $department;

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();

        $this->branch = Branch::factory()->create(['is_active' => true]);
        $this->department = Department::factory()->create();
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'branch_id' => $this->branch->id,
            'department_id' => $this->department->id,
        ]);
    }

    public function test_user_management_list_rendered_correctly()
    {
        $response = $this->actingAs($this->admin)->get(route('users.index'));
        $response->assertStatus(200);
    }

    public function test_can_toggle_user_status_active_blocked()
    {
        $targetUser = User::factory()->create([
            'name' => 'John',
            'last_name' => 'Doe',
            'role' => 'usuario',
            'status' => 'Activo',
            'branch_id' => $this->branch->id,
            'department_id' => $this->department->id,
        ]);

        Livewire::actingAs($this->admin)
            ->test(UserList::class)
            ->call('toggleUserStatus', $targetUser->id);

        $targetUser->refresh();
        $this->assertEquals('Bloqueada', $targetUser->status);

        Livewire::actingAs($this->admin)
            ->test(UserList::class)
            ->call('toggleUserStatus', $targetUser->id);

        $targetUser->refresh();
        $this->assertEquals('Activo', $targetUser->status);
    }

    public function test_can_create_user_with_action_and_send_mail()
    {
        Livewire::actingAs($this->admin)
            ->test(UserForm::class)
            ->set('form.name', 'Maria')
            ->set('form.last_name', 'Gomez')
            ->set('form.email', 'maria@example.com')
            ->set('form.username', 'mariag')
            ->set('form.role', 'usuario')
            ->set('form.status', 'Activo')
            ->set('form.branch_id', $this->branch->id)
            ->set('form.department_id', $this->department->id)
            ->set('form.password', 'Secret123!')
            ->call('save')
            ->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'email' => 'maria@example.com',
            'username' => 'mariag',
            'role' => 'usuario'
        ]);

        Mail::assertSent(UserCredentialsMail::class, function ($mail) {
            return $mail->hasTo('maria@example.com');
        });
    }

    public function test_can_delete_user_via_modal()
    {
        $targetUser = User::factory()->create([
            'role' => 'usuario',
            'branch_id' => $this->branch->id,
            'department_id' => $this->department->id,
        ]);

        Livewire::actingAs($this->admin)
            ->test(UserList::class)
            ->call('confirmDeleteUser', $targetUser->id)
            ->assertSet('userIdSometidoAEliminacion', $targetUser->id)
            ->call('deleteUser')
            ->assertSet('userIdSometidoAEliminacion', null);

        $this->assertSoftDeleted('users', [
            'id' => $targetUser->id
        ]);
    }
}
