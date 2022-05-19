<?php

namespace App\Utils\ApiPlatform\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Order;
use App\Entity\StaticStorage\OrderStaticStorage;
use App\Entity\User;
use App\Event\OrderCreatedFromCartEvent;
use App\Utils\Manager\OrderManager;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class MakeOrderFromCartSubscriber implements EventSubscriberInterface
{
    /**
     * @var Security
     */
    private $security;

    /**
     * @var OrderManager
     */
    private $orderManager;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(Security $security , OrderManager $orderManager , EventDispatcherInterface $eventDispatcher)
    {

        $this->security = $security;
        $this->orderManager = $orderManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function makeOrder(ViewEvent $event)
    {
        $order = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$order instanceof Order || Request::METHOD_POST !== $method) {
            return;
        }



        $order = $this->orderManager->find(14);
        $event = new OrderCreatedFromCartEvent($order);
        $this->eventDispatcher->dispatch($event);
        dd('text from makeorder');





        /** @var User $user */
        $user = $this->security->getUser();
        if(!$user) {
            return;
        }

        $order->setOwner($user);

        $contentJson = $event->getRequest()->getContent();
        if(!$contentJson){
            return;
        }

        $content = json_decode($contentJson ,true);
        if(!array_key_exists('cartId' , $content)){
            return;
        }

        $cartId=(int)$content['cartId'];
        $this->orderManager->addOrderProductsFromCart($order ,$cartId);
        $this->orderManager->recalculateOrderTotalPrice($order);

        $order->setStatus(OrderStaticStorage::ORDER_STATUS_CREATED);
    }

    public function sentNotificationAboutNewOrder (ViewEvent $event)
    {
        $order = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$order instanceof Order || Request::METHOD_POST !== $method) {
            return;
        }

//        $event = new OrderCreatedFromCartEvent($order);
//        $this->eventDispatcher->dispatch($event);
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW =>
            [
                'makeOrder', EventPriorities::PRE_WRITE
            ],
            [
                'sentNotificationAboutNewOrder' , EventPriorities::POST_WRITE
            ]
        ];
    }

}