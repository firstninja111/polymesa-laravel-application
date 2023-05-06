<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Models\Category;
use App\Models\Subcategory;

class CategoryController extends Controller
{
    protected $category;
    protected $subcategory;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Category $category, SubCategory $subcategory)
    {
        $this->category = $category;
        $this->subcategory = $subcategory;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $categories_fetch = $this->category->query()->get();
        return view('categories', ['categories_fetch' => $categories_fetch]);
    }

    public function create(Request $request)    // Create Or Update
    {
        $cnt = $this->category->query()->where('name', $request->name)->get()->count();
        if($cnt != 0)
            return redirect()->back()->with('warning', 'Duplicate Category Name');

        // var_dump($request->editMode);
        // exit(0);

        if($request->editMode == "add")
        {
            $this->category->create([
                'name' => $request->name,
                'className' => $request->icon_classname,
                'mediaType' => $request->mediaType,
                'description' => $request->description,
                'width' => $request->resolution_width,
                'height' => $request->resolution_height,
            ]);
    
            return redirect()->back()->with('success', 'New category is added');
        } else {
            $category = $this->category->find($request->category_id);
            $category->className = $request->icon_classname;
            $category->mediaType = $request->mediaType;
            $category->description = $request->description;
            $category->width = $request->resolution_width;
            $category->height = $request->resolution_height;
            $category->save();

            return redirect()->back()->with('success', 'Category is updated');
        }
    }

    public function destroy(Request $request) {
        
        $this->category->find($request->remove_category_id)->delete();
        return redirect()->back()->with('success', 'Category is deleted.');
    }
    public function getInfo(Request $request)
    {
        $data = $this->category->query()->where('id', $request->id)->first();
        return json_encode($data);
    }

    // ==================== SubCategory Controller ========================= //

    public function subcategoryIndex($id)
    {
        $parentName = $this->category->find($id)->name;
        
        $subcategories_fetch = $this->subcategory->query()->where('parentID', $id)->get();

        return view('subcategories', ['subcategories_fetch' => $subcategories_fetch, 'parentID' => $id, 'parentName' => $parentName]);
    }

    public function destroy_subcategory(Request $request)
    {
        $this->subcategory->find($request->id)->delete();
        return json_encode("success");
    }

    public function subcategory_add(Request $request)
    {
        $cnt = $this->subcategory->query()->where('name', $request->name)->where('parentID', $request->parentID)->get()->count();
        if($cnt != 0)
            return redirect()->back()->with('warning', 'Duplicate Featured Tag Name');

        $this->subcategory->create([
            'name' => $request->name,
            'parentID' => $request->parentID,
        ]);

        return redirect()->back()->with('success', 'SubCategory Added.');
    }

    public function getFromCategory(Request $request)
    {
        $category_id = $request->category_id;
        $subcategories = $this->subcategory->query()->where('parentID', $category_id)->get();

        return json_encode($subcategories);
    }
}
