<?php

namespace App\Http\Controllers\Admin;


use App\Http\Resources\ProductCategoryDepthTreeResource;
use Exception;
use App\Models\ProductCategory;
use App\Services\ProductCategoryService;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\ProductCategoryRequest;
use App\Http\Requests\ChangeImageRequest;
use App\Http\Resources\ProductCategoryResource;

class ProductCategoryController extends AdminController
{
    private ProductCategoryService $productCategoryService;

    public function __construct(ProductCategoryService $productCategory)
    {
        parent::__construct();
        $this->productCategoryService = $productCategory;
        $this->middleware(['permission:promotions'])->only('index', 'changeImage');
        $this->middleware(['permission:promotions_create'])->only('store');
        $this->middleware(['permission:promotions_edit'])->only('update');
        $this->middleware(['permission:promotions_delete'])->only('destroy');
        $this->middleware(['permission:promotions_show'])->only('show');
    }

    public function depthTree(): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return ProductCategoryDepthTreeResource::collection($this->productCategoryService->depthTree());
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function index(PaginateRequest $request): \Illuminate\Http\Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return ProductCategoryResource::collection($this->productCategoryService->list($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }


    public function store(ProductCategoryRequest $request): \Illuminate\Http\Response|ProductCategoryResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return new ProductCategoryResource($this->productCategoryService->store($request));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function show(ProductCategory $productCategory): \Illuminate\Http\Response|ProductCategoryResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return new ProductCategoryResource($this->productCategoryService->show($productCategory));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function update(ProductCategoryRequest $request, ProductCategory $productCategory): \Illuminate\Http\Response|ProductCategoryResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return new ProductCategoryResource($this->productCategoryService->update($request, $productCategory));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function destroy(ProductCategory $productCategory): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            $this->productCategoryService->destroy($productCategory);
            return response('', 202);
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function ancestorsAndSelf(ProductCategory $productCategory): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return ProductCategoryResource::collection($this->productCategoryService->ancestorsAndSelf($productCategory));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function tree()
    {
        try {
            return $this->productCategoryService->tree()->toTree();
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function changeImage(ChangeImageRequest $request, ProductCategory $productCategory): \Illuminate\Http\Response | ProductCategoryResource | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return new ProductCategoryResource($this->productCategoryService->changeImage($request, $productCategory));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }

    public function deleteImage(ProductCategory $productCategory): \Illuminate\Http\Response | ProductCategoryResource | \Illuminate\Contracts\Foundation\Application | \Illuminate\Contracts\Routing\ResponseFactory
    {
        try {
            return new ProductCategoryResource($this->productCategoryService->deleteImage($productCategory));
        } catch (Exception $exception) {
            return response(['status' => false, 'message' => $exception->getMessage()], 422);
        }
    }
}
