<?php

namespace App\Main;
use Illuminate\Support\Facades\Auth;

class TopMenu
{

    public static function menu()
    {

        if (Auth::user()->block_user > 0) {
            return [
                'e-commerce' => [
                    'icon' => 'shopping-bag',
                    'title' => 'Venta',
                    'sub_menu' => [
                        'categories' => [
                            'icon' => '',
                            'route_name' => 'venta_sorteo.create',
                            'params' => [
                                'layout' => 'top-menu'
                            ],
                            'title' => 'Sorteos'
                        ],
                    ]
                ],
            ];
        } else {

            return [
                'dashboard' => [
                    'icon' => 'home',
                    'route_name' => 'dashboard.users',
                    'params' => [
                        'layout' => 'top-menu'
                    ],
                    'title' => 'Principal'
                ],
                'e-commerce' => [
                    'icon' => 'shopping-bag',
                    'title' => 'Venta',
                    'sub_menu' => [
                        'categories' => [
                            'icon' => '',
                            'route_name' => 'venta_sorteo.create',
                            'params' => [
                                'layout' => 'top-menu'
                            ],
                            'title' => 'Sorteos'
                        ],
                        'canjear_loteria' => [
                            'icon' => '',
                            'route_name' => 'canjear.index',
                            'params' => [
                                'layout' => 'top-menu'
                            ],
                            'title' => 'Canjear Loteria'
                        ],
                    ]
                ],
                'point-of-sale' => [
                    'icon' => 'credit-card',
                    'route_name' => 'resumen.index',
                    'params' => [
                        'layout' => 'top-menu'
                    ],
                    'title' => 'Resumen'
                ],
                'chat' => [
                    'icon' => 'message-square',
                    'route_name' => 'resumen.reporteria',
                    'params' => [
                        'layout' => 'top-menu'
                    ],
                    'title' => 'Reportería'
                ],
                'pages' => [
                    'icon' => 'layout',
                    'route_name' => 'resumen.historico',
                    'params' => [
                        'layout' => 'top-menu'
                    ],
                    'title' => 'Histórico'
                ]
            ];
        }

    }

    public static function menu_admin()
    {
        return [
            'dashboard' => [
                'icon' => 'home',
                'route_name' => 'dashboard.admin',
                'params' => [
                    'layout' => 'top-menu'
                ],
                'title' => 'Principal'
            ],
            'juegos' => [
                'icon' => 'book',
                'route_name' => 'juegos.index',
                'params' => [
                    'layout' => 'top-menu'
                ],
                'title' => 'Juegos Hoy'
            ],
            'sorteos' => [
                'icon' => 'book',
                'route_name' => 'sorteos.index',
                'params' => [
                    'layout' => 'top-menu'
                ],
                'title' => 'Sorteos'
            ],
            'resultados' => [
                'icon' => 'layers',
                'route_name' => 'resultados.index',
                'params' => [
                    'layout' => 'top-menu'
                ],
                'title' => 'Carga Resultados'
            ],
            'transacciones' => [
                'icon' => 'activity',
                'route_name' => 'transacciones.index',
                'params' => [
                    'layout' => 'top-menu'
                ],
                'title' => 'Transacciones'
            ],
            'point-of-sale' => [
                'icon' => 'credit-card',
                'route_name' => 'resumen.admin.index',
                'params' => [
                    'layout' => 'top-menu'
                ],
                'title' => 'Resumen'
            ],
            'chat' => [
                'icon' => 'message-square',
                'route_name' => 'resumen.reporteria',
                'params' => [
                    'layout' => 'top-menu'
                ],
                'title' => 'Reportería'
            ],
            'cuentas' => [
                'icon' => 'dollar-sign',
                'route_name' => 'cuentas.index',
                'params' => [
                    'layout' => 'top-menu'
                ],
                'title' => 'Cuentas Agentes'
            ],
            'clientes' => [
                'icon' => 'users',
                'route_name' => 'clientes.index',
                'params' => [
                    'layout' => 'top-menu'
                ],
                'title' => 'Clientes'
            ],
            'usuarios' => [
                'icon' => 'user-check',
                'route_name' => 'user.index',
                'params' => [
                    'layout' => 'top-menu'
                ],
                'title' => 'Usuarios'
            ]
        ];
    }
}
