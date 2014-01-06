<?php
require_once 'controllers/UserImpl.php';
require_once 'controllers/OrderImpl.php';
require_once 'controllers/StatusImpl.php';
require_once 'controllers/PubNubImpl.php';
require_once 'controllers/SearchImpl.php';

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
$userImpl = new UserImpl;
// find all users
$app->get('/users',function() use ($userImpl) {
    $userImpl->findAll();
});
//find an user by name
$app->get('/user/:id', function($id) use ($userImpl) {
    $userImpl->findUser($id);
});
/* //update an user */
/* $app->post('/user', function() use ($userImpl) { */
/*     $userImpl->updateUser(); */
/* }); */
/* //create an user */
/* $app->post('/add/user', function() use ($userImpl) { */
/*     $userImpl->createUser(); */
/* }); */
/* //delete an user */
/* $app->post('/delete/user', function() use ($userImpl) { */
/*     $userImpl->deleteUser(); */
/* }); */

/*--------------------------------*/
/*--------- Order Routes ---------*/
/*--------------------------------*/
$orderImpl = new OrderImpl;
// find orders
$app->get('/orders',function() use ($orderImpl) {
    $orderImpl->findOrders();
});
//get order number
$app->get('/orders/last', function() use ($orderImpl) {
    $orderImpl->getLastOrder();
});
//find specific order
$app->get('/orders/:id', function($id) use ($orderImpl) {
    $orderImpl->findOrderBy($id);
});
//create an order
$app->post('/orders', function() use ($orderImpl) {
    $orderImpl->createOrder();
});
//update an order
$app->put('/orders/:id', function($id) use ($orderImpl) {
    $orderImpl->updateOrder($id);
});

/*--------------------------------*/
/*--------- Status Routes --------*/
/*--------------------------------*/
$statusImpl = new StatusImpl;
// find all status
$app->get('/statuses',function() use ($statusImpl) {
    $statusImpl->findAll();
});
//find an status by name
$app->get('/statuses/:id', function($id) use ($statusImpl) {
    $statusImpl->findStatusBy($id);
});
//create an status
$app->post('/statuses', function() use ($statusImpl) {
    $statusImpl->createStatus();
});
//update an status
$app->put('/statuses/:id', function($id) use ($statusImpl) {
    $statusImpl->updateStatus($id);
});

/*--------------------------------*/
/*--------- Pubnub Routes ---------*/
/*--------------------------------*/
$pubNubImpl = new PubNubImpl;
//get push message 
$app->get('/message',function() use ($pubNubImpl) {
    $pubNubImpl->findAll();
});
//find an message by id
$app->get('/message/:id', function($id) use ($pubNubImpl) {
    $pubNubImpl->findMessage($id);
});
//broadcast push notification
$app->post('/push',function() use ($pubNubImpl) {
    $pubNubImpl->push();
});

/*-------------------------------------------*/
/*--------- searching orders Routes ---------*/
/*-------------------------------------------*/
$searchImpl = new SearchImpl;
// find orders
$app->get('/search',function() use ($searchImpl) {
    $searchImpl->searchOrders();
});
