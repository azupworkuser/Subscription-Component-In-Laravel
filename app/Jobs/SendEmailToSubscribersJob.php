<?php

namespace App\Jobs;

use Mail;
use App\Models\ScheduledEmail;
use Illuminate\Bus\Queueable;
use App\Mail\SendPostEmailToSubscribers;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailToSubscribersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Responsible to send the emails whose status is Pending in ScheduledEmail table
     *
     * @return void
     */
    public function handle()
    {
        ScheduledEmail::where('status', ScheduledEmail::STATUS_PENDING)->get()->each(function ($scheduleEmail) {
            $websitePost = $scheduleEmail->post;
            $sendPostEmailToSubscribersObj = new SendPostEmailToSubscribers($websitePost, $websitePost->website);

            /** Send Mail function using Laravel SMTP */
            try {
                Mail::to($scheduleEmail->user->email)->send($sendPostEmailToSubscribersObj);
                $scheduledEmailStatus = ScheduledEmail::STATUS_SENT;
            } catch (\Exception $e) {
                $scheduledEmailStatus = ScheduledEmail::STATUS_FAILED;
            }

            $scheduleEmail->update([
                'status' => $scheduledEmailStatus,
                'body' => $sendPostEmailToSubscribersObj->render(),
                'to' => $scheduleEmail->user->email
            ]);
        });
    }
}
