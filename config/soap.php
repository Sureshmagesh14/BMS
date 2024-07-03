<?php
return [
    'services' => [
        'netcash' => [
            'wsdl' => 'https://ws.netcash.co.za/NIWS/niws_nif.svc?wsdl',
            'trace' => true,
            'exceptions' => true,
        ],
    ],
    'options' => [],
];
?>