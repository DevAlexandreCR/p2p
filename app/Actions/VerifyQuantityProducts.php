<?php


namespace App\Actions;


use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VerifyQuantityProducts
{
    /**
     * return error if not there's products available
     * @param Request $request
     * @param Product|null $product
     * @throws ValidationException
     */
    public static function execute(Request $request, ?Product $product): void
    {
         if ($product && !self::verifyQuantity($request, $product)) {
             throw ValidationException::withMessages([
                 trans('products.messages.no_stock')
             ]);
         }
    }

    /**
     * verify that there's products to add into cart
     *
     * @param Request $request
     * @param Product $product
     * @return bool
     */
    private static function verifyQuantity(Request $request, Product $product): bool
    {
        $quantityReq = $request->input('quantity');
        $quantityInStock = $product->stock;
        $quantityInCart = $product->pivot->quantity;

        return $quantityInStock >= $quantityInCart + $quantityReq;
    }
}