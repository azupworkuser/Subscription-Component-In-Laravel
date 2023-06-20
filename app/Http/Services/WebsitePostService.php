<?php

namespace App\Http\Services;

use App\Models\WebsitePost;
use Illuminate\Http\Response;

class WebsitePostService
{
    /**
     * Responsible to create website post.
     *
     * @param  User  $user
     * @return array
     */
    public function getPostByWebsiteId($website_id)
    {
        return WebsitePost::where('website_id', $website_id)->get();
    }
}
