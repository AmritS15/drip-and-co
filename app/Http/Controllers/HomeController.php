<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Slide;
use App\Models\Contact;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $slides = Slide::where('status', 1)->get()->take(5);
        $categories = Category::orderBy('name')->get();
        $sproducts = Product::whereNotNull('sale_price')
            ->where('sale_price', '<>', '')
            ->inRandomOrder()
            ->get()
            ->take(8);
        $fproducts = Product::where('featured', 1)->get()->take(8);

        $homeUrl = route('home.index');
        $heroSlide = $slides->firstWhere('link', $homeUrl)
            ?? $slides->firstWhere('link', '/')
            ?? $slides->first();

        $womenCategoryIds = Category::whereRaw('LOWER(name) LIKE ?', ['%women%'])->pluck('id');
        $menCategoryIds = Category::whereRaw("LOWER(name) LIKE '%men%' AND LOWER(name) NOT LIKE '%women%'")->pluck('id');

        $womenCategory = $womenCategoryIds->isNotEmpty()
            ? Category::find($womenCategoryIds->first())
            : null;

        $menCategory = $menCategoryIds->isNotEmpty()
            ? Category::find($menCategoryIds->first())
            : null;

        $womenProducts = $womenCategoryIds->isNotEmpty()
            ? Product::whereIn('category_id', $womenCategoryIds)->orderBy('id', 'DESC')->get()
            : collect();

        $menProducts = $menCategoryIds->isNotEmpty()
            ? Product::whereIn('category_id', $menCategoryIds)->orderBy('id', 'DESC')->get()
            : collect();

        // Section banners: assign left (general shot) and right (close-up) from uploads/sections/
        // Place images in public/uploads/sections/ e.g. section1-general.jpg, section1-closeup.jpg
        $sectionImg = function ($name, $fallback) {
            $path = public_path("uploads/sections/{$name}");
            return file_exists($path) ? asset("uploads/sections/{$name}") : asset($fallback);
        };
        $homeSections = [
            [
                'kicker' => 'Shop by Category',
                'title' => 'Shop the Hoodies Collection',
                'left_image' => $sectionImg('section1-general.jpg', 'assets/images/home/demo3/category_9.jpg'),
                'right_image' => $sectionImg('section1-closeup.jpg', 'assets/images/home/demo3/category_10.jpg'),
                'collection_terms' => ['hoodie', 'hoodies'],
            ],
            [
                'kicker' => 'New Arrivals',
                'title' => 'Discover the Latest Shoes',
                'left_image' => $sectionImg('section2-general.jpg', 'assets/images/home/demo3/product-8.jpg'),
                'right_image' => $sectionImg('section2-closeup.jpg', 'assets/images/home/demo3/category_9.jpg'),
                'collection_terms' => ['shoe', 'shoes'],
            ],
            [
                'kicker' => 'Explore More',
                'title' => 'Shop the Trousers Collection',
                'left_image' => $sectionImg('section3-general.jpg', 'assets/images/home/demo3/product-7.jpg'),
                'right_image' => $sectionImg('section3-closeup.jpg', 'assets/images/home/demo3/category_10.jpg'),
                'collection_terms' => ['trouser', 'trousers'],
            ],
            [
                'kicker' => 'Tops',
                'title' => 'Shirts',
                'left_image' => $sectionImg('section4-general.jpg', 'assets/images/home/demo3/product-4.jpg'),
                'right_image' => $sectionImg('section4-closeup.jpg', 'assets/images/home/demo3/product-5.jpg'),
                'collection_terms' => ['shirt', 'shirts'],
            ],
        ];

        $resolveCollectionBrandIds = function (array $terms) {
            if (empty($terms)) {
                return collect();
            }

            return Brand::query()
                ->where(function ($query) use ($terms) {
                    foreach ($terms as $term) {
                        $needle = '%' . strtolower(trim($term)) . '%';
                        $query->orWhereRaw('LOWER(name) LIKE ?', [$needle])
                            ->orWhereRaw('LOWER(slug) LIKE ?', [$needle]);
                    }
                })
                ->pluck('id')
                ->unique()
                ->values();
        };

        foreach ($homeSections as &$section) {
            $collectionIds = $resolveCollectionBrandIds($section['collection_terms'] ?? []);
            $section['collection_brands'] = $collectionIds->implode(',');
        }
        unset($section);

        return view('index', compact(
            'slides',
            'categories',
            'sproducts',
            'fproducts',
            'womenProducts',
            'menProducts',
            'heroSlide',
            'womenCategory',
            'menCategory',
            'homeSections'
        ));
    }

    public function contact()
    {
        return view('contact');
    }

    public function contact_store(Request $request)
    {
        $request->validate([
            'name'=>'required|max:100',
            'email'=>'required|email',
            'phone'=>'required|numeric|digits:10',
            'comment'=>'required'
        ]);

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->comment = $request->comment;
        $contact->save();
        return redirect()->back()->with('success','Your message has been sent successfully!');
    }

    public function search(Request $request)
    {
    $query = $request->input('query');
    $results = Product::where('name', 'LIKE', "%{$query}%")->get()->take(8);
    return response()->json($results);
    }

    public function about()
    {
        return view('about');
    }
}

    
