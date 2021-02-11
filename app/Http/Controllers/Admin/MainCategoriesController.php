<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddCategoryRequest;
use App\MainCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainCategoriesController extends Controller
{
    public function index()
    {
        $lang = get_default_lang();
        $categories = MainCategory::where('trans_lang', $lang)->select()->paginate(10);
        return view('admin.maincategories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.maincategories.create');
    }

    public function store(AddCategoryRequest $request)
    {


            if ($request->has('photo')) {
                $image = $request->photo->store('main_categories');
            }

            $main_categories = collect($request->category);
            $filter = $main_categories->filter(function ($value, $key) {
                return $value['abbr'] === get_default_lang();
            });
            $defualt_category = array_values($filter->all())[0];

            $defualt_category_id = MainCategory::insertGetId([
                'trans_lang' => $defualt_category['abbr'],
                'trans_of' => 0,
                'name' => $defualt_category['name'],
                'active' => $defualt_category['active'],
                'photo' => $image
            ]);

            $categories = $main_categories->filter(function ($value, $key) {
                return $value['abbr'] !== get_default_lang();
            });

            $categories_arr = [];

            if (isset($categories) && $categories->count() > 0) {
                foreach ($categories as $category) {
                    $categories_arr[] = [
                        'trans_lang' => $category['abbr'],
                        'trans_of' => $defualt_category_id,
                        'name' => $category['name'],
                        'active' => $category['active'],
                        'photo' => $image,
                    ];
                }
            }

            MainCategory::insert($categories_arr);
            return redirect()->route('admin.categories')->with('success','تم إضافة قسم جديد بنجاح ');
    }
}