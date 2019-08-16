<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdController extends Controller
{
    
    public function get_categories() {

    }

    public function get_ads(Request $request, $category_id) {

        $query = Ad::query();
        //Select All elements
        $query->select('ads.*', 'ad_promos.promotype');
        //Category Condition if subcategory or Super Category
        if (isset($sub_category->category_id)) {
            $query->where('category_id', $sub_category->category_id);
        } else {
            $sub_categories = Category::where('parent_id', '=', $super_category->category_id)->select('id')->get();
            $query->whereIn('category_id', $sub_categories);
        }
        

    }
}
