<?php
$data = [[ 'name' => 'test1', 'balance' => 999.99],
         [ 'name' => 'test2', 'balance' => 888.88],
         [ 'name' => 'test3', 'balance' => 777.77]
         ];
header('Content-Type: application/json');
echo json_encode($data);

