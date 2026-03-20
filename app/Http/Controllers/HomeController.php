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
use Illuminate\Support\Str;

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

        
        $heroSlides = Slide::where('status', 1)
            ->where('type', Slide::TYPE_HERO)
            ->orderBy('id')
            ->get();

        
        $standardSlides = Slide::where('status', 1)
            ->where('type', Slide::TYPE_STANDARD)
            ->orderBy('id')
            ->get();

        
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

        
        $categorySliders = Category::query()
            ->where('show_on_home', true)
            ->orderBy('name')
            ->get()
            ->map(function (Category $category) {
                $categoryId = $category->id;
                $brandIdsInCategory = Brand::where('category_id', $categoryId)->pluck('id');
                
                
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

    public function chatbot_reply(Request $request)
    {
        $message = trim((string) $request->input('message', ''));
        if ($message === '') {
            return response()->json(['reply' => "Please type a message and we'll be happy to help."]);
        }

        $reply = $this->buildChatbotReply($message);
        return response()->json(['reply' => $reply]);
    }

    private function buildChatbotReply(string $message): string
    {
        $t = strtolower(trim($message));

        if (preg_match('/\b(hi|hello|hey|howdy|good morning|good afternoon|good evening)\b/i', $t)) {
            return "Hello. Thank you for contacting Drip&Co. How may we assist you today?";
        }

        if (preg_match('/\b(hour|open|close|time|when)\b/i', $t)) {
            return "We aim to respond to all enquiries within 24 hours. For immediate assistance, you can reach us by phone at +44 000-000-0000 or by email at dripandco@outlook.com.";
        }

        if (preg_match('/\b(ship|shipping|delivery|track|tracking|order status|where is my order)\b/i', $t)) {
            return "Delivery and tracking information for your order is available in your account dashboard. Go to Order details to view status and tracking. Once dispatched, tracking details are provided by our third-party delivery partner. We ship across the UK; standard delivery typically takes 3–5 working days.";
        }

        if (preg_match('/\b(return|returns|refund|refunds|exchange|exchanges)\b/i', $t)) {
            return "You can request a return from your account dashboard. Please open your order history, select View Details for the relevant order, and submit your return request from there. Returns are accepted within 30 days. If you need any assistance, our support team will be happy to help.";
        }

        if (preg_match('/\b(contact|email|phone|help|reach|get in touch)\b/i', $t)) {
            return "You can reach us by phone at +44 000-000-0000, by email at dripandco@outlook.com, or via our Contact page using the form there. We're here to help.";
        }

        if (preg_match('/\b(thank|thanks|bye|goodbye|cheers)\b/i', $t)) {
            return "You're welcome. If you need anything else, feel free to ask. Have a great day.";
        }

        $productReply = $this->buildProductReply($message);
        if ($productReply !== null) {
            return $productReply;
        }

        return "Thank you for your message. For detailed assistance, please email us at dripandco@outlook.com or use our contact form, and we'll respond as soon as possible.";
    }

    private function buildProductReply(string $message): ?string
    {
        $normalizedMessage = $this->normalizeForMatch($message);
        $asksStock = preg_match('/\b(stock|in stock|available|availability|quantity|qty|how many)\b/i', $message) === 1;

        $products = Product::with('variants')
            ->select('id', 'name', 'slug', 'short_description', 'description', 'quantity', 'stock_status')
            ->get();

        $matchedProduct = null;
        $bestScore = 0;
        $fullNameMentioned = false;

        foreach ($products as $product) {
            $normalizedName = $this->normalizeForMatch((string) $product->name);
            if ($normalizedName === '') {
                continue;
            }

            if ($normalizedName === $normalizedMessage) {
                $matchedProduct = $product;
                $bestScore = 999;
                $fullNameMentioned = true;
                break;
            }

            if (Str::contains(' ' . $normalizedMessage . ' ', ' ' . $normalizedName . ' ')) {
                $matchedProduct = $product;
                $bestScore = max($bestScore, 500);
                $fullNameMentioned = true;
                continue;
            }

            $score = $this->tokenOverlapScore($normalizedMessage, $normalizedName);
            if ($score > $bestScore) {
                $bestScore = $score;
                $matchedProduct = $product;
            }
        }

        if (!$matchedProduct || $bestScore < 1) {
            if (preg_match('/\b(product|item|stock|available|in stock|variant|size|colour|color)\b/i', $message)) {
                return "Tell me the product name and I can check availability. If you include a size and/or colour, I'll check that exact variant stock.";
            }
            return null;
        }

        $variants = $matchedProduct->variants ?? collect();
        $hasVariants = $variants->count() > 0;
        $productTotalQty = $hasVariants ? (int) $variants->sum('quantity') : (int) $matchedProduct->quantity;
        $productInStock = $productTotalQty > 0 && strtolower((string) $matchedProduct->stock_status) !== 'outofstock';

        $matchedColor = null;
        $matchedSize = null;

        if ($hasVariants) {
            $colors = $variants->pluck('color')->filter()->unique()->values();
            $sizes = $variants->pluck('size')->filter()->unique()->values();

            foreach ($colors as $color) {
                $nColor = $this->normalizeForMatch((string) $color);
                if ($nColor !== '' && preg_match('/\b' . preg_quote($nColor, '/') . '\b/i', $normalizedMessage)) {
                    $matchedColor = (string) $color;
                    break;
                }
            }

            foreach ($sizes as $size) {
                $nSize = $this->normalizeForMatch((string) $size);
                if ($nSize !== '' && preg_match('/\b' . preg_quote($nSize, '/') . '\b/i', $normalizedMessage)) {
                    $matchedSize = (string) $size;
                    break;
                }
            }
        }

        $asksVariant = $matchedColor !== null || $matchedSize !== null || preg_match('/\b(variant|size|colour|color)\b/i', $message);
        if ($hasVariants && $asksVariant) {
            $variantMatches = $variants->filter(function ($v) use ($matchedColor, $matchedSize) {
                $colorOk = $matchedColor === null || strcasecmp((string) $v->color, (string) $matchedColor) === 0;
                $sizeOk = $matchedSize === null || strcasecmp((string) $v->size, (string) $matchedSize) === 0;
                return $colorOk && $sizeOk;
            })->values();

            if ($variantMatches->count() === 0) {
                return "I couldn't find that variant for {$matchedProduct->name}. Please include an available size/colour combination and I'll check exact stock.";
            }

            if ($variantMatches->count() === 1) {
                $v = $variantMatches->first();
                $qty = (int) $v->quantity;
                $status = $qty > 0 ? "in stock" : "out of stock";
                return "{$matchedProduct->name} ({$v->color}, {$v->size}) has {$qty} unit(s) and is currently {$status}.";
            }

            $parts = $variantMatches->map(function ($v) {
                return "{$v->color}/{$v->size}: " . (int) $v->quantity;
            })->take(8)->implode(', ');
            return "Variant stock for {$matchedProduct->name}: {$parts}.";
        }

        if ($asksStock && $fullNameMentioned) {
            if ($hasVariants) {
                $breakdown = $variants->map(function ($v) {
                    return "{$v->color}/{$v->size}: " . (int) $v->quantity;
                })->take(10)->implode(', ');
                return "{$matchedProduct->name} total stock is {$productTotalQty} unit(s). Variant breakdown: {$breakdown}.";
            }
            return "{$matchedProduct->name} stock is {$productTotalQty} unit(s).";
        }

        $statusText = $productInStock ? "in stock" : "out of stock";
        $summary = trim((string) ($matchedProduct->short_description ?: Str::limit((string) $matchedProduct->description, 140)));
        $url = route('shop.product.details', ['product_slug' => $matchedProduct->slug]);
        if ($summary === '') {
            $summary = "This product is currently {$statusText}.";
        }

        return "{$matchedProduct->name}: {$summary} It is currently {$statusText}. For exact quantity, ask with the full product name. For a specific variant, include size and/or colour. {$url}";
    }

    private function normalizeForMatch(string $value): string
    {
        $value = strtolower($value);
        $value = preg_replace('/[^a-z0-9\s]+/i', ' ', $value);
        return trim((string) preg_replace('/\s+/', ' ', (string) $value));
    }

    private function tokenOverlapScore(string $a, string $b): int
    {
        $aTokens = array_values(array_filter(explode(' ', $a), fn($w) => strlen($w) >= 3));
        $bTokens = array_values(array_filter(explode(' ', $b), fn($w) => strlen($w) >= 3));
        if (empty($aTokens) || empty($bTokens)) {
            return 0;
        }
        $bSet = array_flip($bTokens);
        $score = 0;
        foreach ($aTokens as $token) {
            if (isset($bSet[$token])) {
                $score++;
            }
        }
        return $score;
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

    
