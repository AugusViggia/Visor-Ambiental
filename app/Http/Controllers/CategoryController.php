<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Subcategory;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('subcategories')->get();

        return Inertia::render('Categories/CategoriesIndex', [
            'categories' => CategoryResource::collection($categories),
        ]);
    }

    public function create()
    {
        return Inertia::render('Categories/CategoryCreate');
    }

    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        $category = Category::create(['name' => $data['name']]);

        foreach ($data['subcategories'] as $sub) {
            $category->subcategories()->create(['name' => $sub['name']]);
        }

        return redirect()->route('categories.index')->with('success', 'Categoría creada correctamente.');
    }

    public function edit(Category $category)
    {
        $category->load('subcategories');

        return Inertia::render('Categories/CategoryEdit', [
            'category' => new CategoryResource($category),
        ]);
    }

    public function update(StoreCategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        $category->update(['name' => $data['name']]);

        foreach ($data['subcategories'] as $sub) {
            //Si no tiene id es una subcategoría nueva
            //Si existe la actualizamos
            if (!isset($sub['id'])) {
                $category->subcategories()->create(['name' => $sub['name']]);
            } else {
                $subcategory = Subcategory::find($sub['id']);
                $subcategory->update(['name' => $sub['name']]);
            }
        }

        //Eliminamos las subcategorías que no estén en el array de subcategorías
        $category->subcategories()->whereNotIn('id', collect($data['subcategories'])->pluck('id'))->delete();

        return redirect()->route('categories.index')->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(Category $category)
    {
        $category->subcategories()->delete();
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Categoría eliminada exitosamente.');
    }
}
