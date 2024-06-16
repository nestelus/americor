<?php

declare(strict_types=1);

use App\Infrastructure\Yii2App;
use yii\rest\UrlRule;
use yii\web\JsonResponseFormatter;
use yii\web\Response;

$db = require __DIR__ . '/db.php';

$config = [
    'id'                  => 'basic',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log', Yii2App::class],
    'controllerNamespace' => 'App\Infrastructure\Http\Controllers',
    'components'          => [
        'request'    => [
            'enableCookieValidation' => false,
            'enableCsrfValidation'   => false,
            'parsers'                => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'response'   => [
            'class'         => Response::class,
            'format'        => Response::FORMAT_JSON,
            'charset'       => 'UTF-8',
            'formatters'    => [
                Response::FORMAT_JSON => [
                    'class'         => JsonResponseFormatter::class,
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRESERVE_ZERO_FRACTION,
                ],
            ],
            'on beforeSend' => function ($event) {
                return $event->sender;
            },
        ],
        'db'         => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [
                'PUT client/update/<ssn:[A-z0-9-]+>' => 'client/update',
                'GET client/view/<ssn:[A-z0-9-]+>'   => 'client/view',
                'POST loan/issue/<ssn:[A-z0-9-]+>'   => 'loan/issue',
                [
                    'class'      => UrlRule::class,
                    'controller' => ['client', 'loan']
                ],

            ],
        ],
    ],
];

return $config;
