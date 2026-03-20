<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Slide;
use App\Models\Contact;
use App\Models\SiteExperienceRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->get();
        $sproducts = Product::whereNotNull('sale_price')
            ->where('sale_price', '<>', '')
            ->inRandomOrder()
            ->get()
            ->take(8);
        $fproducts = Product::where('featured', 1)->get()->take(8);

        // All active hero-type slides for the homepage slideshow (two images + overlay text each)
        $heroSlides = Slide::where('status', 1)
            ->where('type', Slide::TYPE_HERO)
            ->orderBy('id')
            ->get();

        // Standard slides for the optional slider (single image + tagline/title/subtitle/link)
        $standardSlides = Slide::where('status', 1)
            ->where('type', Slide::TYPE_STANDARD)
            ->orderBy('id')
            ->get();

        // Categories for section links: use "Womens" and "Mens" (exact name, case-insensitive)
        $womenCategory = Category::whereRaw('LOWER(TRIM(name)) = ?', ['womens'])->first();
        $menCategory = Category::whereRaw('LOWER(TRIM(name)) = ?', ['mens'])->first();

        $womenCategoryIds = $womenCategory ? collect([$womenCategory->id]) : collect();
        $menCategoryIds = $menCategory ? collect([$menCategory->id]) : collect();

        $womenProducts = $womenCategoryIds->isNotEmpty()
            ? Product::whereIn('category_id', $womenCategoryIds)->orderBy('id', 'DESC')->get()
            : collect();

        $menProducts = $menCategoryIds->isNotEmpty()
            ? Product::whereIn('category_id', $menCategoryIds)->orderBy('id', 'DESC')->get()
            : collect();

        // All categories for homepage sliders (new categories appear as soon as they’re created)
        $categorySliders = Category::query()
            ->where('show_on_home', true)
            ->orderBy('name')
            ->get()
            ->map(function (Category $category) {
                $categoryId = $category->id;
                $brandIdsInCategory = Brand::where('category_id', $categoryId)->pluck('id');
                // Products in this slider: (1) product assigned to this category, OR
                // (2) product's brand is in this category AND product is not assigned to a different category
                $products = Product::query()
                    ->where(function ($q) use ($categoryId, $brandIdsInCategory) {
                        $q->where('category_id', $categoryId)
                            ->orWhere(function ($q2) use ($categoryId, $brandIdsInCategory) {
                                $q2->whereIn('brand_id', $brandIdsInCategory)
                                    ->where(function ($q3) use ($categoryId) {
                                        $q3->whereNull('category_id')->orWhere('category_id', $categoryId);
                                    });
                            });
                    })
                    ->orderBy('id', 'DESC')
                    ->get();
                $category->setRelation('products', $products);
                return $category;
            });

        // Section banners: assign left (general shot) and right (close-up) from uploads/sections/
        // Place images in public/uploads/sections/ e.g. section1-general.jpg, section1-closeup.jpg
        // Categories = Mens, Womens. Collections = "Womens [Type]" and "Mens [Type]" e.g. Womens Outerwear, Mens Outerwear.
        $sectionImg = function ($name, $fallback) {
            $path = public_path("uploads/sections/{$name}");
            return file_exists($path) ? asset("uploads/sections/{$name}") : asset($fallback);
        };

        $resolveBrandIdByName = function ($name) {
            if (empty($name)) {
                return null;
            }
            $slug = \Illuminate\Support\Str::slug($name);
            $brand = Brand::query()
                ->whereRaw('LOWER(TRIM(name)) = ?', [strtolower(trim($name))])
                ->orWhereRaw('LOWER(slug) = ?', [strtolower($slug)])
                ->first();
            return $brand ? (string) $brand->id : null;
        };

        $homeSections = [
            [
                'kicker' => 'Shop by Category',
                'title' => 'Shop the outerwear collection',
                'left_image' => $sectionImg('section1-general.jpg', 'assets/images/home/demo3/category_9.jpg'),
                'right_image' => $sectionImg('section1-closeup.jpg', 'assets/images/home/demo3/category_10.jpg'),
                'women_collection_name' => 'Womens Outerwear',
                'men_collection_name' => 'Mens Outerwear',
            ],
            [
                'kicker' => 'New Arrivals',
                'title' => 'Discover the latest accessories',
                'left_image' => $sectionImg('section2-general.jpg', 'assets/images/home/demo3/product-8.jpg'),
                'right_image' => $sectionImg('section2-closeup.jpg', 'assets/images/home/demo3/category_9.jpg'),
                'women_collection_name' => 'Womens Accessories',
                'men_collection_name' => 'Mens Accessories',
            ],
            [
                'kicker' => 'Explore More',
                'title' => 'Shop the Trousers Collection',
                'left_image' => $sectionImg('section3-general.jpg', 'assets/images/home/demo3/product-7.jpg'),
                'right_image' => $sectionImg('section3-closeup.jpg', 'assets/images/home/demo3/category_10.jpg'),
                'women_collection_name' => 'Womens Bottoms',
                'men_collection_name' => 'Mens Bottoms',
            ],
            [
                'kicker' => 'Tops',
                'title' => 'Shirts',
                'left_image' => $sectionImg('section4-general.jpg', 'assets/images/home/demo3/product-4.jpg'),
                'right_image' => $sectionImg('section4-closeup.jpg', 'assets/images/home/demo3/product-5.jpg'),
                'women_collection_name' => 'Womens Tops',
                'men_collection_name' => 'Mens Tops',
            ],
        ];

        foreach ($homeSections as &$section) {
            $section['women_collection_brands'] = $resolveBrandIdByName($section['women_collection_name'] ?? '') ?? '';
            $section['men_collection_brands'] = $resolveBrandIdByName($section['men_collection_name'] ?? '') ?? '';
        }
        unset($section);

        return view('index', compact(
            'categories',
            'sproducts',
            'fproducts',
            'womenProducts',
            'menProducts',
            'categorySliders',
            'heroSlides',
            'standardSlides',
            'womenCategory',
            'menCategory',
            'homeSections'
        ));
    }

    public function contact()
    {
        $siteRatingAvg = SiteExperienceRating::avg('rating');
        $siteRatingCount = SiteExperienceRating::count();
        $userRating = null;
        if (Auth::id()) {
            $r = SiteExperienceRating::where('user_id', Auth::id())->first();
            $userRating = $r ? (int) $r->rating : null;
        } else {
            $r = SiteExperienceRating::where('session_id', session()->getId())->first();
            $userRating = $r ? (int) $r->rating : null;
        }
        return view('contact', [
            'siteRatingAvg' => $siteRatingAvg !== null ? round((float) $siteRatingAvg, 1) : null,
            'siteRatingCount' => (int) $siteRatingCount,
            'userRating' => $userRating,
        ]);
    }

    public function site_rating_store(Request $request)
    {
        $request->validate(['rating' => 'required|integer|min:1|max:5']);

        $attrs = ['rating' => (int) $request->rating];
        if (Auth::id()) {
            SiteExperienceRating::updateOrCreate(
                ['user_id' => Auth::id()],
                $attrs
            );
        } else {
            SiteExperienceRating::updateOrCreate(
                ['session_id' => session()->getId()],
                array_merge($attrs, ['session_id' => session()->getId()])
            );
        }

        $siteRatingAvg = SiteExperienceRating::avg('rating');
        $siteRatingCount = SiteExperienceRating::count();

        return response()->json([
            'ok' => true,
            'average' => $siteRatingAvg !== null ? round((float) $siteRatingAvg, 1) : null,
            'count' => (int) $siteRatingCount,
        ]);
    }

    public function contact_store(Request $request)
    {
        $request->validate([
            'name'=>'required|max:100',
            'email'=>'required|email',
            'phone'=>'required|numeric|digits:11',
            'comment'=>'required'
        ], [
            'phone.digits' => 'The phone number must be 11 digits.',
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
        $query = trim((string) $request->input('query', ''));
        if ($query === '') {
            return response()->json(['products' => [], 'categories' => [], 'brands' => []]);
        }

        $term = '%' . $query . '%';

        $products = Product::where('name', 'LIKE', $term)
            ->select('id', 'name', 'slug', 'image')
            ->take(6)
            ->get();

        $categories = Category::where('name', 'LIKE', $term)
            ->select('id', 'name', 'image')
            ->take(5)
            ->get();

        $brands = Brand::where('name', 'LIKE', $term)
            ->select('id', 'name', 'category_id', 'image')
            ->take(5)
            ->get();

        return response()->json([
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }

    public function about()
    {
        return view('about');
    }

    public function privacy()
    {
        return view('privacy');
    }

    public function terms()
    {
        return view('terms');
    }

    public function modern_slavery()
    {
        return view('modern-slavery');
    }

    public function accessibility()
    {
        return view('accessibility');
    }
}

    
