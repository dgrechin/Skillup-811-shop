<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Repository\OrderRepository;
use App\Service\OrdersService;
use phpDocumentor\Reflection\Types\Object_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrdersController extends AbstractController
{
    /**
     * @Route("/orders", name="orders")
     */
    public function index()
    {
        return $this->render('orders/cart.html.twig', [
            'controller_name' => 'OrdersController',
        ]);
    }

    /**
     * @Route("/orders/add-to-cart/{id}", name="orders_add_to_cart")
     */
    public function addToCart(Product $product, OrdersService $ordersService, Request $request)
    {
        $order = $ordersService->addToCart($product);
        $referer = $request->headers->get('referer');
        $response = $this->redirect($referer);
        $response->headers->setCookie(new Cookie('order_id' , $order->getId(),new \DateTime('+1 year')));

        return $response;
    }
    /**
     * @Route("/orders/cart", name="cart")
     */
    public function cart(OrdersService $ordersService)
    {
        return $this->render('orders/cart.html.twig', [
            'cart' => $ordersService->getOrderFromRequest()]);
    }
    /**
     * @Route("/orders/cart-in-header", name="orders_cart_in_header")
     */
    public function cartInHeader(OrdersService $ordersService)
    {
        $cart = $ordersService->getOrderFromRequest();
        return $this->render('orders/cartInHeader.html.twig', [
            'cart' => $cart]);
    }
}
