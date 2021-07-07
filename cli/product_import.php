<?php

// Load Opencart config
require_once(dirname(__DIR__) . '/config.php');

require_once dirname(__DIR__) . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use App\Service\ProductImport;

$connection = new AMQPStreamConnection(RABBITMQ_HOST, RABBITMQ_PORT, RABBITMQ_USER, RABBITMQ_PASS);
$channel = $connection->channel();

$channel->queue_declare('import', false, true, false, false);

$callback = function ($msg) {
    $data = json_decode($msg->body, true);

    (new ProductImport())->import($data);

    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
};

$channel->basic_qos(null, 1, null);
$channel->basic_consume('import', '', false, false, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();