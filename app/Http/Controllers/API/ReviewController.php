<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\CreateReviewRequest;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends ApiController
{
    public function store(CreateReviewRequest $createReviewRequest)
    {
        $input = $createReviewRequest->only('rating', 'main_impression', 'review', 'product_id');
        $input['created_by'] = $this->guard()->id();

        $existingReview = Review::where('created_by', $this->guard()->id())
            ->where('product_id', $input['product_id'])
            ->first();

        if ($existingReview) {
            return $this->badRequest('review_exist', 'Review allready exist!');
        }
        Review::create($input);
        return $this->requestSuccess();
    }
}
