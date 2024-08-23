<?php

namespace App\Services;


use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\PaginateRequest;
use App\Libraries\QueryExceptionLibrary;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\ChangeImageRequest;

class CategoryService
{
    protected array $productCateFilter = [
        'name',
        'slug',
        'description',
        'status',
        'parent_id'
    ];

    protected array $exceptFilter = [
        'excepts'
    ];


    /**
     * @throws Exception
     */
    public function ancestorsAndSelf(Category $category)
    {
        try {
            return $category->ancestorsAndSelf->reverse();
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * @throws Exception
     */
    public function depthTree()
    {
        try {
            return Category::tree()->depthFirst()->get();
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * @throws Exception
     */
    public function tree()
    {
        try {
            return Category::active()->tree()->get();
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * @throws Exception
     */
    public function list(PaginateRequest $request)
    {
        try {
            $requests    = $request->all();
            $method      = $request->get('paginate', 0) == 1 ? 'paginate' : 'get';
            $methodValue = $request->get('paginate', 0) == 1 ? $request->get('per_page', 10) : '*';
            $orderColumn = $request->get('order_column') ?? 'id';
            $orderType   = $request->get('order_type') ?? 'desc';

            return Category::tree()->depthFirst()->with('parent_category', 'media', 'products')->where(function ($query) use ($requests) {
                foreach ($requests as $key => $request) {
                    if (in_array($key, $this->productCateFilter)) {
                        $query->where($key, 'like', '%' . $request . '%');
                    }

                    if (in_array($key, $this->exceptFilter)) {
                        $explodes = explode('|', $request);
                        if (is_array($explodes)) {
                            foreach ($explodes as $explode) {
                                $query->where('id', '!=', $explode);
                            }
                        }
                    }
                }
            })->orderBy($orderColumn, $orderType)->$method(
                $methodValue
            );
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * @throws Exception
     */
    public function store(CategoryRequest $request)
    {
        try {
            $categorySlug = Str::slug($request->name);
            $slug = Category::where('slug', $categorySlug)->first();
            if($slug){
                $categorySlug = Str::slug($request->name).$request->parent_id;
            }
            $category = Category::create(Arr::except($request->validated(), 'parent_id') + ['slug' => $categorySlug, 'parent_id' => $request->parent_id == 'NULL' ? NULL : $request->parent_id]);
            if ($request->image) {
                $category->addMediaFromRequest('image')->toMediaCollection('category');
            }
            return $category;
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * @throws Exception
     */
    public function update(CategoryRequest $request, Category $category): Category
    {
        try {
            $category->update(Arr::except($request->validated(), 'parent_id') + ['slug' => Str::slug($request->name), 'parent_id' => $request->parent_id == 'NULL' ? NULL : $request->parent_id]);
            if ($request->image) {
                $category->clearMediaCollection('category');
                $category->addMediaFromRequest('image')->toMediaCollection('category');
            }
            return $category;
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }

    /**
     * @throws Exception
     */
    public function destroy(Category $category): void
    {
        try {
            $productSubCategory = Category::find($category->id)->children()->get();
            if (!blank($productSubCategory)) {
                throw new Exception(trans('all.message.resource_already_used'), 422);
            } else {
                $checkProduct = $category->products->whereNull('deleted_at');
                if (!blank($checkProduct)) {
                    $category->delete();
                } else {
                    DB::statement('SET FOREIGN_KEY_CHECKS=0');
                    $category->delete();
                    DB::statement('SET FOREIGN_KEY_CHECKS=1');
                }
            }
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception(QueryExceptionLibrary::message($exception), 422);
        }
    }

    /**
     * @throws Exception
     */
    public function show(Category $category): Category
    {
        try {
            return $category;
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }
    public function changeImage(ChangeImageRequest $request, Category $category): Category
    {
        try {
            if ($request->image) {
                $category->clearMediaCollection('category');
                $category->addMedia($request->image)->toMediaCollection('category');
            }
            return $category;
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage(), 422);
        }
    }
}
