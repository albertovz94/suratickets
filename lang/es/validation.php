<?php

return [
    'required' => 'El campo :attribute es obligatorio.',
    'image' => 'El campo :attribute debe ser una imagen.',
    'string' => 'El campo :attribute debe ser texto.',
    'email' => 'El campo :attribute debe ser un correo electrónico válido.',
    'unique' => 'El campo :attribute ya ha sido registrado.',
    
    'max' => [
        'string' => 'El campo :attribute no debe ser mayor a :max caracteres.',
        'file' => 'El archivo :attribute no debe pesar más de :max kilobytes.',
    ],
    
    'attributes' => [
        'proofPhoto' => 'foto de evidencia',
        'deliveryNote' => 'nota de entrega',
        'adminNote' => 'nota del administrador',
        'newCommentBody' => 'comentario',
        'device_type' => 'tipo de equipo',
        'description' => 'descripción',
    ],
];
