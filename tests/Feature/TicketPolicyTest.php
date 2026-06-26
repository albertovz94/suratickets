<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Department;
use App\Models\Branch;
use App\Policies\TicketPolicy;

class TicketPolicyTest extends TestCase
{
    use RefreshDatabase;

    private function createUserWithRole($role)
    {
        return User::factory()->create([
            'role' => $role,
            'department_id' => Department::factory()->create()->id,
            'branch_id' => Branch::factory()->create()->id,
        ]);
    }

    public function test_admin_can_view_any_ticket()
    {
        $admin = $this->createUserWithRole('admin');
        $ticket = Ticket::factory()->create();

        $policy = new TicketPolicy();
        $this->assertTrue($policy->view($admin, $ticket));
    }

    public function test_outsourcing_can_view_any_ticket()
    {
        $outsourcing = $this->createUserWithRole('outsourcing');
        $ticket = Ticket::factory()->create();

        $policy = new TicketPolicy();
        $this->assertTrue($policy->view($outsourcing, $ticket));
    }

    public function test_usuario_can_only_view_own_ticket()
    {
        $usuario = $this->createUserWithRole('usuario');
        $otherUsuario = $this->createUserWithRole('usuario');
        
        $ownTicket = Ticket::factory()->create(['creator_id' => $usuario->id]);
        $otherTicket = Ticket::factory()->create(['creator_id' => $otherUsuario->id]);

        $policy = new TicketPolicy();
        $this->assertTrue($policy->view($usuario, $ownTicket));
        $this->assertFalse($policy->view($usuario, $otherTicket));
    }

    public function test_admin_and_outsourcing_can_update_any_ticket()
    {
        $admin = $this->createUserWithRole('admin');
        $outsourcing = $this->createUserWithRole('outsourcing');
        $ticket = Ticket::factory()->create();

        $policy = new TicketPolicy();
        $this->assertTrue($policy->update($admin, $ticket));
        $this->assertTrue($policy->update($outsourcing, $ticket));
    }

    public function test_usuario_cannot_update_tickets()
    {
        $usuario = $this->createUserWithRole('usuario');
        // El policy actual requiere hasAdminAccess() para update. Si el usuario intenta editar el status, devuelve false.
        $ownTicket = Ticket::factory()->create(['creator_id' => $usuario->id]);

        $policy = new TicketPolicy();
        $this->assertFalse($policy->update($usuario, $ownTicket));
    }
}
