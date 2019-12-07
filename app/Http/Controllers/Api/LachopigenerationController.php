<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Cache;
use App\Category;
use App\Http\Controllers\AdController;

set_time_limit(180);

/**
 * Class for LaChopi DB Generation
 */
class LachopigenerationController extends Controller
{

    private $categories;
    private $superCats;
    private $categories_parsed;
    private $final_cats;
    private $db;

    /**
     * Initialize variables, check for security first
     */
    public function __construct()
    {
        //Echo the Categories Generated Complete
        echo "<h2>Begin Process \"LaChopi Generation\"</h2>";
        ob_flush();
        flush();

        //Get All Categories
        //Global Cached Categories Data Cache one week
        $this->categories = Cache::rememberForever('cached_categories', function () {
            return Category::with('description')->get();
        });

        //Get DB Link and perform somr cleaning operations
        /*
        $this->bd = new \SQLite3('../sitios/lachopi/chcenter.db');
        $this->bd->exec("DELETE FROM cats");
        $this->bd->exec("DELETE FROM anuncios");
        $this->bd->exec("DELETE FROM meta");
        $this->bd->exec("DELETE FROM imagenes");
        $this->bd->exec("VACUUM");
        */

        //Save Categories, Flush and Optimize
        foreach ($this->categories as $category) {
            //If this is a Parent Catgory, skip loop
            if (is_null($category->parent_id))
                continue;

            $cat = new \stdClass();
            $cat->id = $this->get_key_based_category($category->id);
            $cat->original_id = $category->id;
            $cat->cat = $this->get_key_based_supercategory($category->parent_id);
            $cat->subcat = strtolower($category->description->name);
            $cat->name = $category->description->name;
            $this->categories_parsed[] = $cat;
        }

        //CuperCateories instance
        $i = 1;
        $this->superCats = [
            (object) ['name' => 'Computación', 'cat' => 0],
            (object) ['name' => 'Transporte', 'cat' => 0],
            (object) ['name' => 'Electrónica', 'cat' => 0],
            (object) ['name' => 'Hogar', 'cat' => 0],
            (object) ['name' => 'Salud y Belleza', 'cat' => 0],
            (object) ['name' => 'Servicios', 'cat' => 0],
            (object) ['name' => 'Otros', 'cat' => 0],
        ];

        //Final Variable Categories
        $this->final_cats = array_merge($this->superCats, $this->categories_parsed);

        //Echo the Categories Generated Complete
        echo "<h2>Generando categorias: Done!</h2>";
        ob_flush();
        flush();

        //Dump this final category
        //dd($this->final_cats);

        //Iterate and save categories in DB and add a 7 if is a subcategory
        foreach ($this->final_cats as &$category) {
            if (!isset($category->subcat))
                $category->subcat = '';
            if (isset($category->id)) {
                $new_cat = $category->id + 7;
                $sql = "INSERT INTO cats (id_cat, name, parent, name_bc) VALUES (" . $new_cat . ", '" . $category->name . "', '" . $category->cat . "', '" . $category->subcat . "')";
            } else {
                $sql = "INSERT INTO cats (id_cat, name, parent, name_bc) VALUES (" . $i++ . ", '" . $category->name . "', '" . $category->cat . "', '" . $category->subcat . "')";
            }

            //Echo the Categories Generated Complete
            echo "<h2>Insertando Categorías</h2>";
            echo "<h3>$sql</h3>";
            ob_flush();
            flush();

            //Save this category in DataBase
            //$this->bd->exec($sql);
        }
    }

    /**
     * Full generation logic here
     */
    public function generate()
    {
        //Iterate here over evey category
        foreach ($this->categories_parsed as $category) {

            //Echo the Categories Generated Complete
            echo "<h2>Retrieve Ads from: $category->name</h2>";
            ob_flush();
            flush();

            //Get all ads from this category
            $ads = $this->getCategoryAds($category->original_id);

            //Iterate over this ads resul set
            if ($ads->total() >= 1) {

                foreach ($ads as $ad) {

                    //Small dump of this AD:
                    echo $ad->id . " **|** " . $ad->description->title . " **|** "  . substr($ad->description->description, 0, 60) . " **|** " . $ad->price . "<br>";

                    //Save this list to the sqlite DB


                    //Get ready all variables
                    //Insert into Query

                    //Try to combine 10 o more queries on one
                    //Fetch images also to do a BLOB object

                }
            }

            exit;
        }
    }

    /**
     * Get alls ads from specific category
     */
    public function getCategoryAds($category_id)
    {
        //This is called every category ID, so retrieve ads from it
        $request = new Request();
        $limit = 1000;
        $latest_days = 7;

        return AdController::getAds($request, $category_id, $limit, $latest_days);
    }

    /**
     * Shift the Original ID of the categories table
     * to a more simple representation ordered list
     */
    private function get_key_based_category($category_id)
    {
        $cats = [
            1 => 103, 2 => 104, 3 => 105, 4 => 106, 5 => 107, 6 => 108, 7 => 109, 8 => 110, 9 => 111,
            10 => 112, 11 => 113, 12 => 114, 13 => 115, 14 => 116, 15 => 117, 16 => 112, 17 => 118,
            18 => 119, 19 => 120, 20 => 121, 21 => 122, 22 => 123, 23 => 124, 24 => 125, 25 => 125,
            26 => 125, 27 => 126, 28 => 127, 29 => 128, 30 => 129, 31 => 129, 32 => 130, 33 => 131,
            34 => 133, 35 => 134, 36 => 135, 37 => 136, 38 => 132, 39 => 137, 40 => 138, 41 => 139,
            42 => 140, 43 => 141, 44 => 142, 45 => 143, 46 => 144, 47 => 145, 48 => 146, 49 => 147,
            50 => 148, 51 => 149, 52 => 150, 53 => 151, 54 => 152, 55 => 153, 56 => 154, 57 => 155,
            58 => 156, 59 => 157, 60 => 158, 61 => 159, 62 => 160, 63 => 151, 64 => 161
        ];

        //Search for the Key of this value $category_id
        $cat = array_keys($cats, (int) $category_id);

        return $cat[0];
    }

    /**
     * Translate Super Category onto a more simple
     * ID notation
     */
    private function get_key_based_supercategory($id_cat)
    {
        $superCtas = [
            1 => 96,        //Computadoras
            2 => 100,       //Transporte
            3 => 97,        //Electrónica
            4 => 99,        //Hogar
            5 => 101,       //Salud y Belleza
            6 => 98,        //Servicios
            7 => 102        //Otros
        ];

        $id_cat = array_keys($superCtas, (int) $id_cat);
        return (string) $id_cat[0];
    }
}
