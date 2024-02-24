<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Customer;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        //birthday task
        $userBirthday = $this->customer->whereDay('dob', now()->day)
            ->whereMonth('dob', now()->month)
        ->get();

        foreach ($userBirthday as $user) {
            $schedule->call(function () use ($user) {
                $response = Http::post('https://email-service.digitalenvision.com.au/send-email', [
                    "email" => $user->email,
                    "message" => "Hey, ".$user->name." it's your birthday!"
                ]);
            })->dailyAt('9:00')->timezone($user->timezone);
        }
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
