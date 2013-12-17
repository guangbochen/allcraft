<?php
require_once 'controllers/UserImpl.php';
require_once 'controllers/OrderImpl.php';
require_once 'controllers/StatusImpl.php';
require_once 'controllers/PushImpl.php';
require_once 'controllers/PubNubImpl.php';

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
    $orderImpl->findAll();
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
$app->get('/status',function() use ($statusImpl) {
    $statusImpl->findAll();
});
//find an status by name
$app->get('/status/:id', function($id) use ($statusImpl) {
    $statusImpl->findStatusBy($id);
});
//create an status
$app->post('/status', function() use ($statusImpl) {
    $statusImpl->createStatus();
});
//update an status
$app->put('/status/:id', function($id) use ($statusImpl) {
    $statusImpl->updateStatus($id);
});

/*--------------------------------*/
/*--------- Pubnub Routes ---------*/
/*--------------------------------*/
$pubNubImpl = new PubNubImpl;
// find all status
$app->get('/push',function() use ($pubNubImpl) {
    $pubNubImpl->push();
});

