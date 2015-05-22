<?php

namespace Mon\QcmBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class Builder
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }


    public function mainMenu(AuthorizationCheckerInterface $authorizationCheckerInterface)
    {
        // Menu will be a navbar menu anchored to right
        $menu = $this->factory->createItem('root', array(
            'navbar' => true
        ));

        if (!$authorizationCheckerInterface->isGranted('ROLE_USER')) {

            $menu->addChild('Contact', array('route' => 'mon_qcm_contact'));

            return $menu;
        }

        $menu->addChild('Home', array('route' => 'mon_qcm_homepage'));
        $menu->addChild('Contact', array('route' => 'mon_qcm_contact'));

        if ($authorizationCheckerInterface->isGranted('ROLE_ADMIN')) {
            $menu->addChild('Admin', array('route' => 'mon_qcm_admin_qcm'));
        }

        return $menu;
    }

    public function userMenu(AuthorizationCheckerInterface $authorizationCheckerInterface, TokenStorage $tokenStorage)
    {
        // Menu will be a navbar menu anchored to right
        $menu = $this->factory->createItem('root', array(
            'navbar' => true,
            'pull-right' => true
        ));

        if (!$authorizationCheckerInterface->isGranted('ROLE_USER')) {
            return $menu;
        }

        // Create a dropdown with a caret
        $dropdown = $menu->addChild($tokenStorage->getToken()->getUser()->getName(), array(
            'dropdown' => true,
            'caret' => true,
        ));

        // Create a dropdown header
        $dropdown->addChild('Logout', array('route' => 'mon_qcm_security_logout'));


        return $menu;
    }
}