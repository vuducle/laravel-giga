<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReviewController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Review::class);

        return ReviewResource::collection(Review::all());
    }

    public function store(ReviewRequest $request)
    {
        $this->authorize('create', Review::class);

        return new ReviewResource(Review::create($request->validated()));
    }

    public function show(Review $review)
    {
        $this->authorize('view', $review);

        return new ReviewResource($review);
    }

    public function update(ReviewRequest $request, Review $review)
    {
        $this->authorize('update', $review);

        $review->update($request->validated());

        return new ReviewResource($review);
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);

        $review->delete();

        return response()->json();
    }
}
