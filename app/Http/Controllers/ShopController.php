<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Schema;

class ShopController extends Controller
{
    public function landing(Request $request)
    {
        $filterKeys = ['page', 'size', 'order', 'brands', 'categories', 'sizes', 'colors', 'sale', 'min', 'max'];
        foreach ($filterKeys as $key) {
            if ($request->query($key) !== null && $request->query($key) !== '') {
                return $this->renderShop($request);
            }
        }

        $shopMensUrl = route('shop.mens');
        $shopWomensUrl = route('shop.womens');

        return view('shop-landing', compact('shopMensUrl', 'shopWomensUrl'));
    }

    public function index(Request $request)
    {
        return $this->renderShop($request);
    }

    public function mens(Request $request)
    {
        return $this->renderShop($request, ['mens', 'men'], ['mens', 'men', "men's"]);
    }

    public function womens(Request $request)
    {
        return $this->renderShop($request, ['womens', 'women'], ['womens', 'women', "women's"]);
    }

    protected function renderShop(Request $request, array $forcedSlugs = [], array $forcedNamesLower = [])
    {
        $forcedCategoryId = $this->resolveCategoryId($forcedSlugs, $forcedNamesLower);
        $lockCategory = $forcedCategoryId !== null;
        $size = $request->query('size') ? $request->query('size') : 12;
        $o_column = "";
        $o_order = "";
        $order = $request->query('order') ? $request->query('order') : -1;
        $f_brands = $request->query('brands');
        $f_categories = $lockCategory ? (string) $forcedCategoryId : $request->query('categories');
        $fsizes = $request->query('sizes');
        $fcolors = $request->query('colors');
        $onSale = $request->query('sale') === '1';
        $min_price = $request->query('min') ? $request->query('min') : 1;
        $max_price = $request->query('max') ? $request->query('max') : 250;
        switch ($order) {
            case 1:
                $o_column = 'created_at';
                $o_order = 'DESC';
                break;
            case 2:
                $o_column = 'created_at';
                $o_order = 'ASC';
                break;
            case 3:
                $o_column = 'sale_price';
                $o_order = 'ASC';
                break;
            case 4:
                $o_column = 'sale_price';
                $o_order = 'DESC';
                break;
            default:
                $o_column = 'id';
                $o_order = 'DESC';
        }
        $brandIds = array_values(array_filter(array_map('intval', explode(',', (string) $f_brands))));
        $categoryIds = array_values(array_filter(array_map('intval', explode(',', (string) $f_categories))));
        if ($lockCategory) {
            $categoryIds = [$forcedCategoryId];
        }
        $sizes = array_values(array_filter(array_map('trim', explode(',', (string) $fsizes))));
        $colors = array_values(array_filter(array_map('trim', explode(',', (string) $fcolors))));

        $min_price = is_numeric($min_price) ? (float) $min_price : 1;
        $max_price = is_numeric($max_price) ? (float) $max_price : 250;

        $brands = Brand::query()
            ->when($lockCategory, function ($query) use ($forcedCategoryId) {
                $query->whereHas('products', function ($productQuery) use ($forcedCategoryId) {
                    $productQuery->where('category_id', $forcedCategoryId);
                });
            })
            ->withCount(['products' => function ($query) use ($lockCategory, $forcedCategoryId) {
                if ($lockCategory) {
                    $query->where('category_id', $forcedCategoryId);
                }
            }])
            ->orderBy('name', 'ASC')
            ->get();
        $categories = Category::query()
            ->withCount('products')
            ->orderBy('name', 'ASC')
            ->get();

        $hasVariants = Schema::hasTable('product_variants');

        $productsQuery = Product::query()
            ->with(['reviews', 'variants'])
            ->when($brandIds, function ($query) use ($brandIds) {
                $query->whereIn('brand_id', $brandIds);
            })
            ->when($categoryIds, function ($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds);
            })
            ->where(function ($query) use ($min_price, $max_price) {
                $query->whereBetween('regular_price', [$min_price, $max_price])
                    ->orWhereBetween('sale_price', [$min_price, $max_price]);
            })
            ->when($onSale, function ($query) {
                $query->whereNotNull('sale_price')
                    ->where('sale_price', '>', 0);
            });

        if ($hasVariants) {
            
            $productsQuery->where(function ($query) {
                $query->where('quantity', '>', 0)
                    ->orWhereHas('variants', function ($q) {
                        $q->where('quantity', '>', 0);
                    });
            });

            
            $productsQuery
                ->when($colors, function ($query) use ($colors) {
                    $query->whereHas('variants', function ($q) use ($colors) {
                        $q->where(function ($q2) use ($colors) {
                            foreach ($colors as $color) {
                                $q2->orWhere('color', $color);
                            }
                        })->where('quantity', '>', 0);
                    });
                })
                ->when($sizes, function ($query) use ($sizes) {
                    $query->whereHas('variants', function ($q) use ($sizes) {
                        $q->where(function ($q2) use ($sizes) {
                            foreach ($sizes as $s) {
                                $q2->orWhere('size', $s);
                            }
                        })->where('quantity', '>', 0);
                    });
                });
        } else {
            
            $productsQuery->where('quantity', '>', 0);
        }

        $products = $productsQuery
            ->orderBy($o_column, $o_order)
            ->paginate($size);

        return view('shop', compact(
            'products',
            'size',
            'order',
            'brands',
            'f_brands',
            'categories',
            'f_categories',
            'fsizes',
            'fcolors',
            'min_price',
            'max_price',
            'onSale',
            'lockCategory'
        ));
    }

    protected function resolveCategoryId(array $slugs, array $namesLower): ?int
    {
        $category = Category::query()->whereIn('slug', $slugs)->first();
        if (! $category && $namesLower !== []) {
            $placeholders = implode(',', array_fill(0, count($namesLower), '?'));
            $category = Category::query()
                ->whereRaw('LOWER(name) IN ('.$placeholders.')', $namesLower)
                ->first();
        }
        if (! $category) {
            return null;
        }

        return (int) $category->id;
    }

    public function product_details($product_slug)
    {
        $product = Product::with(['reviews','variants'])->where('slug',$product_slug)->first();
        $rproducts = Product::where('slug','<>',$product_slug)->take(8)->get();
        return view('details',compact('product','rproducts'));
    }

    public function store_review(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required',
            'email' => 'required|email',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required'
        ]);

        Review::create([
            'product_id' => $request->product_id,
            'name' => $request->name,
            'email' => $request->email,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return back()->with('success', 'Review submitted successfully!');
    }
}
