<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\WebsitePostRequest;
use App\Models\WebsitePost;
use App\Models\Website;
use App\Http\Resources\WebsitePost as WebsitePostResource;
use App\Http\Services\WebsitePostService;

class WebsitePostController extends BaseController
{
    protected $websitePostService;

    /**
     * Create a new WebsitePostController instance.
     *
     * @param WebsitePostService $websitePostService
     * @return void
     */
    public function __construct(WebsitePostService $websitePostService)
    {
        $this->websitePostService = $websitePostService;
    }

    /**
     * Responsible to get the post for the given website
     * @param Website $website
     * @return json
     * */
    public function index(Website $website)
    {
        $websitePosts = $this->websitePostService->getPostByWebsiteId($website->id);

        /** Return the website posts list in json format */
        return $this->sendResponse(WebsitePostResource::collection($websitePosts), 'Website Posts List.');
    }

    /**
     * Responsible to create a new post for the given website
     * @param Website $website
     * @param WebsitePostRequest $request
     * @return json
     * */
    public function store(Website $website, WebsitePostRequest $request) {
        $websitePost = WebsitePost::create($request->all() + ['website_id' => $website->id]);

        /** Return the website created in json format */
        return $this->sendResponse(new WebsitePostResource($websitePost), 'Website Post is created.');
    }

    /**
     * Responsible to update an existing post for the given website
     * @param WebsitePostRequest $request
     * @param Website $website
     * @param WebsitePost $websitePost
     * @return json
     * */
    public function update(WebsitePostRequest $request) {

        $websitePost = WebsitePost::findOrFail($request->route('id'));
        $websitePost->update($request->all());
        
        /** Return the website updated in json format */
        return $this->sendResponse(new WebsitePostResource($websitePost), 'Website Post is updated.');
    }
}
