<?php
require_once 'controllers/UserImpl.php';
require_once 'controllers/OrderImpl.php';

//SET INDEX PAGE
$app->get('/', function(){
    echo json_encode(array(
        'status' => 'OK',
        'http_code' => 200,
        'message' => 'Allcraft API is healthy'
    ));
});

/*--------------------------------*/
/*--------- USER ROUTES ----------*/
/*--------------------------------*/
$user_controller = new UserImpl;
// find all users
$app->get('/users',function() use ($user_controller) {
    $user_controller->findAll();
});
//find an user by name
$app->get('/user/:id', function($id) use ($user_controller) {
    $user_controller->findUser($id);
});
/* //update an user */
/* $app->post('/user', function() use ($user_controller) { */
/*     $user_controller->updateUser(); */
/* }); */
/* //create an user */
/* $app->post('/add/user', function() use ($user_controller) { */
/*     $user_controller->createUser(); */
/* }); */
/* //delete an user */
/* $app->post('/delete/user', function() use ($user_controller) { */
/*     $user_controller->deleteUser(); */
/* }); */

/*--------------------------------*/
/*--------- USER ROUTES ----------*/
/*--------------------------------*/
$order_controller = new OrderImpl;
// find all users
$app->get('/orders',function() use ($order_controller) {
    $order_controller->findAll();
});
//find an user by name
$app->get('/orders/:id', function($id) use ($order_controller) {
    $order_controller->findOrderBy($id);
});
//create an user
$app->post('/orders', function() use ($order_controller) {
    $order_controller->createOrder();
});





