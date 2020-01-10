<?php

namespace App\Http\Controllers\Resources;

use App\Exceptions\DomainException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddCartItem as AddCartItemRequest;
use App\Http\Resources\CartItem as CartItemResource;
use App\Services\CartItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    private $cartItemService;

    public function __construct(CartItem $cartItemService)
    {
        $this->cartItemService = $cartItemService;
    }

    public function index(string $cart)
    {
        $cart = $this->cartItemService->findCartById($cart);

        return $cart->exists()
            ? CartItemResource::collection($cart->getItems())
            : abort(404);
    }

    public function store(AddCartItemRequest $request, string $cart)
    {
        try {
            $cart = $this->cartItemService->addItem($cart, $request->get('id'), $request->get('amount'));
            return CartItemResource::collection($cart->getItems());
        } catch (DomainException $e) {
            return new JsonResponse(['message' => $e->getMessage()], 422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
