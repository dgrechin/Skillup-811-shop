<?php

namespace App\Controller;


use App\Entity\OrderItem;
use App\Entity\Product;
use App\Form\OrderType;
use App\Service\OrdersService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrdersController extends AbstractController
{

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
        if ($request->isXmlHttpRequest()){
            $response = $this->render('orders/cartInHeader.html.twig',[
                'cart'=>$order,
            ]);
        }else{
        $referer = $request->headers->get('referer');
        $response = $this->redirect($referer);
        }

        $response->headers->setCookie(new Cookie('orderId' , $order->getId(),new \DateTime('+1 year')));

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
    /**
     * @Route("/orders/remove-item/{id}", name="order_remove_item")
     */
    public function removeItem(OrderItem $orderItem, OrdersService $ordersService,Request $request)
    {
        $ordersService->removeItem( $orderItem);
        if ($request->isXmlHttpRequest())
        {
            return $this->render('orders/cartItems.html.twig',
            [
                'cart'=>$ordersService->getOrderFromRequest(),
            ]);
        }
        return $this->redirectToRoute('cart');
    }
    /**
     * @Route("/orders/set-order-quntity/{id}", name="order_set_item_quantity")
     */
    public  function  setOrderQuantity(OrderItem $orderItem, OrdersService $ordersService, Request $request)
    {
        $ordersService->setItemQuantity($orderItem, $request->request->get('quantity'));
        if ($request->isXmlHttpRequest())
        {
            return $this->render('orders/cartItems.html.twig',
                [
                    'cart'=>$ordersService->getOrderFromRequest(),
                ]);
        }
        return $this->redirectToRoute('cart');
    }
    /**
     * @Route("/orders/create", name="orders_create_order")
     */
    public function createOrder(OrdersService $ordersService , Request $request)

    {
        $order= $ordersService->prepareOrder($this->getUser());
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $ordersService->sendOrder($order);
            $response=$this->redirectToRoute('payments_make_payment', ['id' =>$order->getId()]);
            $response->headers->clearCookie('orderId');

            return $response;
        }
        return $this->render('order/createOrder.html.twig',[
            'order'=>$order,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/orders/thanks", name="orders_thanks")
     */
    public function orderThanks()
    {
        return $this -> render('orders\thanks.html.twig');
    }
}
