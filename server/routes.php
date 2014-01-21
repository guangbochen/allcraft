<?php
require_once 'helpers/Authen.php';
require_once 'controllers/UserImpl.php';
require_once 'controllers/OrderImpl.php';
require_once 'controllers/StatusImpl.php';
require_once 'controllers/NotificationImpl.php';
require_once 'controllers/SearchImpl.php';
require_once 'controllers/FilesImpl.php';
require_once 'controllers/MessageImpl.php';

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
//validate user login 
$app->post('/login', function() use ($userImpl) {
    $userImpl->login();
});
//find an user by name
/* $app->get('/user/:id', function($id) use ($userImpl) { */
/*     $userImpl->findUser($id); */
/* }); */
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
$app->get('/orders', function() use ($orderImpl) {
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
/*-----Notification Routes -------*/
/*--------------------------------*/
$notificationImpl = new NotificationImpl;
//get push message 
$app->get('/notifications',function() use ($notificationImpl) {
    $notificationImpl->findAll();
});
//find an message by id
$app->get('/notifications/:id', function($id) use ($notificationImpl) {
    $notificationImpl->findMessage($id);
});

/*-------------------------------------------*/
/*--------- searching orders Routes ---------*/
/*-------------------------------------------*/
$searchImpl = new SearchImpl;
// find orders
$app->get('/search',function() use ($searchImpl) {
    $searchImpl->searchOrders();
});

/*-------------------------------------------*/
/*--------- upload  files Routes ------------*/
/*-------------------------------------------*/
$filesImpl = new FilesImpl;
// upload files
$app->post('/upload',function() use ($filesImpl) {
    $filesImpl->uploadFiles();
});
$app->get('/files',function() use ($filesImpl) {
    $filesImpl->getAllFiles();
});
$app->get('/files/:id',function($id) use ($filesImpl) {
    $filesImpl->getFilesBy($id); //find files belongs to unique order number
});

/*-------------------------------------------*/
/*--------- upload  files Routes ------------*/
/*-------------------------------------------*/
$messageImpl = new MessageImpl;
// find messsage
$app->get('/messages',function() use ($messageImpl) {
    $messageImpl->findByUser();
});
$app->post('/messages/setRead',function() use ($messageImpl) {
    $messageImpl->setAllMessagesAsRead();
});

