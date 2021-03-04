<?php

function info($data, $context = [])
{
    if (count($context) < 1) {
        $message = $data;
        echo json_encode($message) . PHP_EOL;
    } else {
        $message = ['data' => $data, 'context' => $context];
    }
    echo json_encode($message) . PHP_EOL;
}
