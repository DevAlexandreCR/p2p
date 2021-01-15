<?php


namespace App\Constants;


use MyCLabs\Enum\Enum;

class Permissions extends Enum
{
    //users
    public const VIEW_USERS = 'view users';
    public const EDIT_USERS = 'edit users';
    public const DELETE_USERS = 'delete users';
    public const CREATE_USERS = 'create users';

    //orders
    public const VIEW_ORDERS = 'view orders';
    public const EDIT_ORDERS = 'edit orders';
    public const CREATE_ORDERS = 'create orders';
    public const DELETE_ORDERS = 'delete orders';

    //products
    public const VIEW_PRODUCTS = 'view products';
    public const EDIT_PRODUCTS = 'edit products';
    public const CREATE_PRODUCTS = 'create products';
    public const DELETE_PRODUCTS = 'delete products';

    //payments
    public const VIEW_PAYMENTS = 'view payments';
    public const EDIT_PAYMENTS = 'edit payments';
    public const CREATE_PAYMENTS = 'create payments';
    public const DELETE_PAYMENTS = 'delete payments';

    //cart
    public const VIEW_CART = 'view cart';
    public const EDIT_CART = 'edit cart';
    public const CREATE_CART = 'create cart';
    public const DELETE_CART = 'delete cart';

    //roles
    public const VIEW_ROLES = 'view roles';
    public const EDIT_ROLES = 'edit roles';
    public const CREATE_ROLES = 'create roles';
    public const DELETE_ROLES = 'delete roles';

    //payers
    public const VIEW_PAYERS = 'view payers';
    public const EDIT_PAYERS = 'edit payers';
    public const CREATE_PAYERS = 'create payers';
    public const DELETE_PAYERS = 'delete payers';

}
