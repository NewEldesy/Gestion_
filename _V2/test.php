<?php
    include('model.php');

    $item = [
        [
            'produitId' => 1,
            'produitPrix' => 30000
        ],
        [
            'produitId' => 2,
            'produitPrix' => 15000
        ],
        [
            'produitId' => 3,
            'produitPrix' => 30000
        ],
    ];

    $items = json_encode($item, JSON_PRETTY_PRINT);

    $total = 45000; $venteId = 10; $prestataire = 1; $remise = 5;
    $data['items'] = $items; $data['total'] = $total; $data['venteId'] = $venteId;
    $data['prestataire'] = $prestataire; $data['remise'] = $remise;

    add_Prestation($data);