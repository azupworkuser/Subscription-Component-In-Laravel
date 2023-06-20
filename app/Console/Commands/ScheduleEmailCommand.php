<?php

namespace App\Console\Commands;

use App\Models\WebsitePost;
use App\Models\ScheduledEmail;
use Illuminate\Console\Command;
use App\Models\WebsiteSubscription;
use App\Jobs\SendEmailToSubscribersJob;

class ScheduleEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmd:schedule-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule the email';

    /** @var WebsitePost $websitePost */
    private $websitePost;

    /**
     * Create a new command instance.
     *
     * @param WebsitePost $websitePost
     * @return void
     */
    public function __construct(WebsitePost $websitePost)
    {
        parent::__construct();
        $this->websitePost = $websitePost;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /** Schedule email for all the subscribers of the Website with Pending status */
        WebsiteSubscription::where('website_id', $this->websitePost->website->id)->get()->each(function ($websiteSubscription) {
            $email = new ScheduledEmail();
            $email->fill([
                'user_id' => $websiteSubscription->subscriber->id,
                'website_post_id' => $this->websitePost->id,
                'status' => ScheduledEmail::STATUS_PENDING
            ]);
            $email->save();
        });

        /** Dispatch the background job (asynchroniously) to send the emails whose status is Pending in ScheduledEmail table */
        dispatch(new SendEmailToSubscribersJob());
        return 0;
    }
}
