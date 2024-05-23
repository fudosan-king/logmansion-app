<?php

return [
    'department' => [
        '0' => 'LogSuite',
        '1' => 'LogArchitect',
        //  '2'   =>   'LogAsset'
    ],       
    'category_doc' => [
        '0'     => '押印済み書類',
        '1'     => '管理系資料',
        '2'     => '付属資料',
    ],
    'schedule'  => '決済までの流れ',
    'warranty'  => '保証期',
    'paging'  => 10,
    "user" => "削除",
    'doc_categories' => [0, 1, 2],
    'doc_payment_category' => 3,
    'warranty_period_category' => 4,
    'contact_type' => [
        '0' => 'その他',
        '1' => 'お問い合わせ',
        '2' => 'アフターサービスのご相談'
    ],
    'contact_status' => [
        '0' => '相談受付',
        '1' => '回答待ち',
        '2' => '応答済',
        '3' => '対応終了',
    ],
    'contact_spot' => [
        '0' => 'その他',
        '1' => 'キッチン',
        '2' => '浴室',
        '3' => '洗面',
        '4' => '給排水',
        '5' => 'その他水回り',
        '6' => '壁・クロス',
        '7' => '床',
        '8' => '建具',
    ],
    'text_search' => [
        '0' => 'エンドユーザー名',
        '1' => '最終対応者名',
        '2' => '全対応者',
        '3' => 'お問合せの種類',
    ],
    'field_search_contact' => [
        '0' => 'client_id',
        '1' => 'user_id',
        '2' => 'author',
        '3' => 'contact_type',
    ],
    'author_type_staff'  => 1,
    'author_type_client'  => 0,
];
