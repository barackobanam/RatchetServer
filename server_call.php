<?php
 $entryData = array(
    'category' => 'kittensCategory',
    'title'    =>  "<img src = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSQythd0ly14qbZd7YEJ9WreTX4-dBQw7vfGS33ZXbTQRJjE1AHITKZE5g' /></br>"
);
$context = new ZMQContext();
$socket = $context->getSocket(ZMQ::SOCKET_PUSH, 'my pusher');
$socket->connect("tcp://localhost:5555");

$socket->send(json_encode($entryData));
die('disconnect');