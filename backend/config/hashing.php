<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Hash Driver
    |--------------------------------------------------------------------------
    | Chọn driver mặc định: 'argon2id' hoặc 'bcrypt'
    */
    'driver' => 'argon2id', // Hoặc 'bcrypt'

    'bcrypt' => [
        'rounds' => 12, // Tăng độ phức tạp khi tính toán
    ],

    'argon2id' => [
        'memory' => 65536, // Dung lượng bộ nhớ (64 MB)
        'threads' => 1,     // Số luồng xử lý
        'time'    => 4,     // Số vòng lặp thời gian
    ],
];