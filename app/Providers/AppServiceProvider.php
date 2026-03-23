<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    
    public function register(): void
    {
        
    }

    
    public function boot(): void
    {
        Validator::extend('contains_number', function ($attribute, $value) {
            if (!is_string($value)) {
                return false;
            }
            return preg_match('/\d/', $value) === 1;
        });

        Validator::extend('contains_uppercase', function ($attribute, $value) {
            if (!is_string($value)) {
                return false;
            }
            return preg_match('/[A-Z]/', $value) === 1;
        });

        View::composer('layouts.app', function ($view) {
            $shopUrlForCategory = function (array $slugs, array $namesLower): string {
                $category = Category::query()->whereIn('slug', $slugs)->first();
                if (! $category && $namesLower !== []) {
                    $placeholders = implode(',', array_fill(0, count($namesLower), '?'));
                    $category = Category::query()
                        ->whereRaw('LOWER(name) IN ('.$placeholders.')', $namesLower)
                        ->first();
                }
                if (! $category) {
                    return route('shop.all');
                }

                return route('shop.all', ['categories' => $category->id]);
            };

            $view->with([
                'footerShopMensUrl' => $shopUrlForCategory(
                    ['mens', 'men'],
                    ['mens', 'men', "men's"]
                ),
                'footerShopWomensUrl' => $shopUrlForCategory(
                    ['womens', 'women'],
                    ['womens', 'women', "women's"]
                ),
            ]);
        });
    }
}
