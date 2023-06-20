<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Website;
use App\Models\WebsiteSubscription;
use App\Http\Resources\WebsiteSubscription as WebsiteSubscriptionResource;
use App\Http\Controllers\API\BaseController;

class WebsiteSubscriptionController extends BaseController
{
    /**
     * Responsible to subscribe user to the given website
     * @param Website $website
     * @param User $user
     * @return json
     * */
    public function store(Website $website, User $user)
    {
        /** Create a new subscription */
        $websiteSubscription = WebsiteSubscription::create([
            'website_id' => $website->id,
            'user_id'    => $user->id,
        ]);

        /** Return WebsiteSubscription Object in json format */
        return $this->sendResponse(new WebsiteSubscriptionResource($websiteSubscription), 'User Subscribed to the Given Website.');
    }
}
