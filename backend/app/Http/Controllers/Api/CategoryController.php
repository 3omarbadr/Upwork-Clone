<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        return $this->apiResponse(Category::all());
    }

    public function show($id)
    {
        $category = Category::find($id);

        if ($category) {
            return $this->apiResponse($category);
        }

        return $this->NotFoundError();
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return $this->apiResponse($category);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return $this->apiResponse($category, '', 200);

    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if ($category) {
            $category->jobs()->delete();
            $category->freelancers()->delete();
            $category->delete();
            return $this->apiResponse(true, '', 200);
        }

        return $this->NotFoundError();
    }
}
