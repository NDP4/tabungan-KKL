<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Saving;
use Illuminate\Console\Command;
use App\Notifications\WeeklyReminder;
use App\Notifications\SavingConfirmed;
use App\Notifications\CustomResetPassword;
use Illuminate\Support\Facades\Storage;

class PreviewEmail extends Command
{
    protected $signature = 'email:preview {type : Type of email (reset-password|weekly-reminder|payment-confirmation)}';
    protected $description = 'Preview email templates with sample data';

    public function handle(): void
    {
        $type = $this->argument('type');
        $user = User::factory()->make([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'nim' => 'A22.2023.00001'
        ]);

        $notification = match ($type) {
            'reset-password' => new CustomResetPassword('dummy-token'),
            'weekly-reminder' => new WeeklyReminder(50000, 25000),
            'payment-confirmation' => new SavingConfirmed($this->createDummySaving($user)),
            default => throw new \InvalidArgumentException('Invalid email type'),
        };

        $email = $notification->toMail($user);
        $html = $email->render();

        $path = storage_path("app/public/email-preview-{$type}.html");
        file_put_contents($path, $html);

        $this->info("Email preview saved to: {$path}");
        if (PHP_OS_FAMILY === 'Linux') {
            shell_exec("xdg-open {$path}");
        } elseif (PHP_OS_FAMILY === 'Darwin') {
            shell_exec("open {$path}");
        } elseif (PHP_OS_FAMILY === 'Windows') {
            shell_exec("start {$path}");
        }
    }

    private function createDummySaving(User $user): Saving
    {
        return new Saving([
            'user_id' => $user->id,
            'amount' => 50000,
            'status' => 'approved',
            'sequence_number' => 1,
            'payment_method' => 'transfer'
        ]);
    }
}
