<?php

require_once __DIR__ . '/vendor/autoload.php';

use app\models\Orders;
use app\models\Products;

if (!isset($_POST['product_id'], $_POST['product_count'], $_POST['phone'])) {
    echo json_encode(['error' => 'Не указаны обязательные поля']);
    exit;
}

try {
    $product = Products::one($_POST['product_id']);

    if (!$product) {
        echo json_encode(['error' => 'Такого товара нет']);
        exit;
    }

    $order = [
        'product_id' => $product['id'],
        'product_name' => $product['name'],
        'product_price' => $product['price'],
        'product_count' => $_POST['product_count'],
        'created_at' => date('Y-m-d H:i:s'),
        'phone' => $_POST['phone'],

    ];

    Orders::add($order);

    echo json_encode(['success' => 1]);
} catch (Throwable $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

