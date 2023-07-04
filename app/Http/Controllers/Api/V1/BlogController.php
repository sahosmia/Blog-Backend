<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Blog\StoreBlogRequest;
use App\Http\Requests\Api\V1\Blog\UpdateBlogRequest;
use App\Models\Blog;
use App\Http\Resources\V1\BlogResource;
use App\Traits\ApiStatus;

class BlogController extends Controller
{
    use ApiStatus;

    public function index()
    {
        try {
            $datas = Blog::paginate(25);
            return BlogResource::collection($datas)->additional($this->StatusResource());
        } catch (\Exception $execption) {
            return $execption;
        }
    }


    public function create()
    {
    }


    public function store(StoreBlogRequest $request)
    {
        $input = $request->only(['title', 'category_id', 'description', 'photo']);
        try {
            Blog::create($input);
            return $this->StatusSuccess([], 'Data Store Successfuly');
        } catch (\Exception $execption) {
            return $this->StatusError($execption->getMessage());
        }
    }


    public function show(Blog $blog)
    {
        try {
            return (new BlogResource($blog))->additional($this->StatusResource());
        } catch (\Exception $execption) {
            return $this->StatusError($execption->getMessage());
        }
    }


    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $input = $request->only(['title', 'category_id', 'description', 'photo']);
        try {
            $blog->update($input);
            return $this->StatusSuccess($blog, 'Data Update Successfuly');
        } catch (\Exception $execption) {
            return $this->StatusError($execption->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        try {
            $blog->delete();
            return $this->StatusSuccess([], 'Data Delete Successfuly');
        } catch (\Exception $execption) {
            return $this->StatusError($execption->getMessage());
        }
    }
}
