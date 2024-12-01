<?php

namespace App\Console\Commands;

use App\Models\Callback;
use App\Models\Employee;
use App\Notifications\DateUpdatedNotification;
use App\Notifications\TestNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class NotificationUpdateDates extends Command
{
    protected $signature = 'app:notification-update-dates';
    protected $description = 'Update callback notification dates';

    public function handle()
    {
        try {
            $current = Carbon::today();
            $previousDate = $current->copy()->subDay();
            $records = Callback::whereDate('new_date', $previousDate)
                ->where('day', '<', 6)
                ->where('status', 5)
                ->get();

            foreach ($records as $record) {
                $userIds = array_filter([
                    1,
                    $record->manager_id,
                    $record->teamleader_id,
                    $record->consultant_id
                ]);

                if (!empty($userIds)) {
                    $users = Employee::whereIn('id', $userIds)
                        ->where('active_status', 1)
                        ->get();

                    $day = $record->day + 1;
                    $record->day = $day;
                    $record->new_date = $current;

                    foreach ($users as $user) {
                        try {
                            // $user->notifications()->delete();
                            $user->notify(new \App\Notifications\DateUpdatedNotification($record));
                            $record->update(['day' => $day, 'new_date' => $current]);
                        } catch (\Exception $e) {
                            Log::error('Error sending test notification', [
                                'user_id' => $user->id,
                                'error' => $e->getMessage(),
                            ]);
                        }
                    }
                }
            }

            $this->info('Dates updated successfully!');
            Log::info('NotificationUpdateDates command completed.');
            return 0;
        } catch (\Exception $e) {
            Log::error('Error in NotificationUpdateDates command: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            return 1;
        }
    }
}
