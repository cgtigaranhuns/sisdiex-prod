<?php

return [

    'fields' => [

        'search' => [
            'label' => 'Cerca',
            'placeholder' => 'Cerca',
        ],

    ],

    'pagination' => [

        'label' => 'Paginació',

        'overview' => 'Mostrant :first a :last de :total resultatss',

        'fields' => [

            'records_per_page' => [
                'label' => 'per pàgina',
            ],

        ],

        'actions' => [

            'go_to_page' => [
                'label' => 'Anar a la pàgina :page',
            ],

            'next' => [
                'label' => 'Següent',
            ],

            'previous' => [
                'label' => 'Anterior',
            ],

        ],

    ],

    'actions' => [

        'filter' => [
            'label' => 'Filtre',
        ],

        'open_bulk_actions' => [
            'label' => 'Open actions',
        ],

    ],

    'empty' => [
        'heading' => 'No s\'han trobat registres.',
    ],

    'selection_indicator' => [

        'actions' => [

            'select_all' => [
                'label' => 'Select all :count',
            ],

        ],

    ],

];
