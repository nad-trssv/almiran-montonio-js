<?php

namespace App\Exports;

use App\Http\Requests\PaginateRequest;
use App\Libraries\AppLibrary;
use App\Services\CategoryService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CategoryExport implements FromCollection, WithHeadings
{

    public CategoryService $categoryService;
    public PaginateRequest $request;

    public function __construct(CategoryService $categoryService, $request)
    {
        $this->categoryService = $categoryService;
        $this->request      = $request;
    }

    public function collection()
    {
        $categoryArray  = [];
        $categoriesArray = $this->categoryService->list($this->request);

        foreach ($categoriesArray as $category) {
            $categoryArray[] = [
                $category->name,
                $category->slug,
                trans('statuse.' . $category->status),
            ];
        }
        return collect($categoryArray);
    }

    public function headings(): array
    {
        return [
            trans('all.label.name'),
            trans('all.label.slug'),
            trans('all.label.status'),
        ];
    }
}
