<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Website;
use App\Http\Resources\Website as WebsiteResource;

class WebsiteController extends BaseController
{
    /**
     * Responsible to return the list of active websites
     *
     * @return Json
     */
    public function index()
    {
        $websites = Website::where('status', true)->get();

        /** Return the website list in json format */
        return $this->sendResponse(WebsiteResource::collection($websites), 'Website List.');
    }
}
