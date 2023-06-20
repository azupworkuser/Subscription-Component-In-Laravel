<?php

namespace App\Mail;

use App\Models\WebsitePost;
use App\Models\Website;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendPostEmailToSubscribers extends Mailable
{
    use Queueable, SerializesModels;

    /** @var WebsitePost $websitePost */
    private $websitePost;

    /** @var Website $website */
    private $website;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(WebsitePost $websitePost, Website $website)
    {
        $this->website = $website;
        $this->websitePost = $websitePost;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.send-create-post-email')
            ->subject("{$this->website->name} Added new post")
            ->with([
                'post' => $this->websitePost,
                'website' => $this->website
            ]);
    }
}
