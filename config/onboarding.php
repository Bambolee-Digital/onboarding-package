<?php

return [
    // Prefixo das rotas da API
    'route_prefix' => 'api/onboarding',

    // Middlewares aplicados às rotas da API
    'middleware' => ['api', 'auth:api'],

    // Configurações adicionais podem ser adicionadas aqui
];
