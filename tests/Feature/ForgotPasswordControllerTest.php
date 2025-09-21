<?php

namespace Tests\Feature;

use App\Events\PasswordResetRequested;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgotPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_sends_password_reset_link_and_fires_event()
    {
        $this->withoutExceptionHandling();
        Notification::fake();
        Event::fake();

        $user = User::factory()->create([
            'email'=>'john@example.com'
        ]);

        $response = $this->post(route('password.email'), [
            'email'=>'john@example.com'
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'status'=>'We have emailed your password reset link.'
        ]);

        Notification::assertSentTo($user, ResetPassword::class);

        Event::assertDispatched(PasswordResetRequested::class, function ($event) use ($user) {
            return $event->email === $user->email;
        });
    }
}
