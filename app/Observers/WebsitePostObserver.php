<?php

namespace App\Observers;

use App\Models\WebsitePost;
use App\Console\Commands\ScheduleEmailCommand;

class WebsitePostObserver
{
    /**
     * Handle the WebsitePost "updated" event.
     * @param  \App\Models\WebsitePost $websitePost
     * @return void
     */
    public function updated(WebsitePost $websitePost)
    {
        /** Schedule the email to all the subscribers of the website associated, if WebsitePost is published */
        if ($websitePost->isDirty('status') && ($websitePost->getOriginal('status') == WebsitePost::STATUS_INACTIVE && $websitePost->status == WebsitePost::STATUS_ACTIVE)) {
            dispatch(new ScheduleEmailCommand($websitePost));
        }
    }
}
