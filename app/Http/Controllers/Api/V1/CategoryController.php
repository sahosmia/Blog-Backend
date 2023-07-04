<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Category\StoreCategoryRequest;
use App\Http\Requests\Api\V1\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Http\Resources\V1\CategoryResource;
use App\Traits\ApiStatus;

class CategoryController extends Controller
{
    use ApiStatus;

    public function index()
    {
        try {
            $datas = Category::paginate(25);
            return CategoryResource::collection($datas)->additional($this->StatusResource());
        } catch (\Exception $execption) {
            return $execption;
        }
    }


    public function create()
    {
    }


    public function store(StoreCategoryRequest $request)
    {
        $input = $request->only(['title', 'description']);
        try {
            Category::create($input);
            return $this->StatusSuccess([], 'Data Store Successfuly');
        } catch (\Exception $execption) {
            return $this->StatusError($execption->getMessage());
        }
    }


    public function show(Category $category)
    {
        try {
            return (new CategoryResource($category))->additional($this->StatusResource());
        } catch (\Exception $execption) {
            return $this->StatusError($execption->getMessage());
        }
    }


    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $input = $request->only(['title', 'description']);
        try {
            $category->update($input);
            return $this->StatusSuccess($category, 'Data Update Successfuly');
        } catch (\Exception $execption) {
            return $this->StatusError($execption->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return $this->StatusSuccess([], 'Data Delete Successfuly');
        } catch (\Exception $execption) {
            return $this->StatusError($execption->getMessage());
        }
    }
}
