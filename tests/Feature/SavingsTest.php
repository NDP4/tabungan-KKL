<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Saving;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Contracts\Auth\Authenticatable;

class SavingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_submit_savings(): void
    {
        /** @var User&Authenticatable $user */
        $user = User::factory()->create([
            'email' => '122202300001@mhs.dinus.ac.id',
            'nim' => 'A22.2023.00001',
            'role' => 'mahasiswa'
        ]);

        $response = $this->actingAs($user)->post('/savings', [
            'amount' => 10000,
            'payment_method' => 'transfer',
            'notes' => 'Test payment'
        ]);

        $response->assertRedirect('/savings/' . Saving::first()->id . '/confirm');
        $this->assertDatabaseHas('savings', [
            'user_id' => $user->id,
            'amount' => 10000,
            'status' => 'pending'
        ]);
    }

    public function test_treasurer_can_approve_savings(): void
    {
        /** @var User&Authenticatable $treasurer */
        $treasurer = User::factory()->create(['role' => 'bendahara']);

        /** @var User&Authenticatable $student */
        $student = User::factory()->create(['role' => 'mahasiswa']);

        $saving = Saving::factory()->create([
            'user_id' => $student->id,
            'status' => 'pending'
        ]);

        $response = $this->actingAs($treasurer)
            ->patch("/admin/savings/{$saving->id}", [
                'status' => 'approved'
            ]);

        $response->assertSuccessful();
        $this->assertDatabaseHas('savings', [
            'id' => $saving->id,
            'status' => 'approved'
        ]);
    }

    public function test_validates_weekly_minimum(): void
    {
        /** @var User&Authenticatable $user */
        $user = User::factory()->create(['role' => 'mahasiswa']);

        $response = $this->actingAs($user)->post('/savings', [
            'amount' => 5000,
            'payment_method' => 'transfer'
        ]);

        $response->assertSessionHasErrors('amount');
    }

    public function test_validates_student_email_format(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Student',
            'email' => 'invalid@email.com',
            'nim' => 'A22.2023.00001',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_validates_nim_format(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test Student',
            'email' => '122202300001@mhs.dinus.ac.id',
            'nim' => 'INVALID-NIM',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertSessionHasErrors('nim');
    }

    public function test_can_store_saving(): void
    {
        /** @var User&Authenticatable $admin */
        $admin = User::factory()->create(['role' => 'bendahara']);
        $this->actingAs($admin);

        $response = $this->post('/savings', [
            'amount' => 10000,
            'payment_method' => 'transfer',
            'notes' => 'Test saving'
        ]);

        $response->assertRedirect();
    }

    public function test_can_confirm_saving_by_other(): void
    {
        /** @var User&Authenticatable $admin */
        $admin = User::factory()->create(['role' => 'bendahara']);
        $this->actingAs($admin);

        $saving = Saving::factory()->create([
            'user_id' => User::factory()->create(['role' => 'mahasiswa'])->id,
            'status' => 'pending'
        ]);

        $response = $this->patch("/admin/savings/{$saving->id}", [
            'status' => 'approved'
        ]);

        $response->assertSuccessful();
    }

    public function test_cannot_confirm_own_saving(): void
    {
        /** @var User&Authenticatable $admin */
        $admin = User::factory()->create(['role' => 'bendahara']);
        $this->actingAs($admin);

        $saving = Saving::factory()->create([
            'user_id' => $admin->id,
            'status' => 'pending'
        ]);

        $response = $this->patch("/admin/savings/{$saving->id}", [
            'status' => 'approved'
        ]);

        $response->assertForbidden();
    }
}
