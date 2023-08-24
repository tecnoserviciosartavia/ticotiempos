<?php

namespace App\Main;

class SideMenu
{
    public static function menu()
    {
            return [
                'dashboard' => [
                    'icon' => 'home',
                    'route_name' => 'dashboard.users',
                    'params' => [
                        'layout' => 'side-menu'
                    ],
                    'title' => 'Principal'
                ],
                'menu-layout' => [
                    'icon' => 'box',
                    'title' => 'Menu Layout',
                    'sub_menu' => [
                        'side-menu' => [
                            'icon' => '',
                            'route_name' => 'dashboard.users',
                            'params' => [
                                'layout' => 'side-menu'
                            ],
                            'title' => 'Side Menu'
                        ],
                        'simple-menu' => [
                            'icon' => '',
                            'route_name' => 'dashboard.users',
                            'params' => [
                                'layout' => 'simple-menu'
                            ],
                            'title' => 'Simple Menu'
                        ],
                        'top-menu' => [
                            'icon' => '',
                            'route_name' => 'dashboard.users',
                            'params' => [
                                'layout' => 'top-menu'
                            ],
                            'title' => 'Top Menu'
                        ]
                    ]
                ],
                'e-commerce' => [
                    'icon' => 'shopping-bag',
                    'title' => 'Venta',
                    'sub_menu' => [
                        'categories' => [
                            'icon' => '',
                            'route_name' => 'venta_sorteo.create',
                            'params' => [
                                'layout' => 'side-menu'
                            ],
                            'title' => 'Sorteos'
                        ],
                        /*'add-product' => [
                            'icon' => '',
                            'route_name' => 'venta_sorteo.create',
                            'params' => [
                                'layout' => 'side-menu'
                            ],
                            'title' => 'Parlay',
                        ],*/
                        'reviews' => [
                            'icon' => '',
                            'route_name' => 'venta_sorteo.create',
                            'params' => [
                                'layout' => 'side-menu'
                            ],
                            'title' => 'Tripleta'
                        ],
                        'fechas' => [
                            'icon' => '',
                            'route_name' => 'venta_sorteo.create',
                            'params' => [
                                'layout' => 'side-menu'
                            ],
                            'title' => 'Fechas'
                        ],
                        'loteria' => [
                            'icon' => '',
                            'route_name' => 'venta_sorteo.create',
                            'params' => [
                                'layout' => 'side-menu'
                            ],
                            'title' => 'Loteria'
                        ],
                        'rifa' => [
                            'icon' => '',
                            'route_name' => 'venta_sorteo.create',
                            'params' => [
                                'layout' => 'side-menu'
                            ],
                            'title' => 'Rifa'
                        ],
                        'canjear_loteria' => [
                            'icon' => '',
                            'route_name' => 'venta_sorteo.create',
                            'params' => [
                                'layout' => 'side-menu'
                            ],
                            'title' => 'Canjear Loteria'
                        ],
                    ]
                ],
                'point-of-sale' => [
                    'icon' => 'credit-card',
                    'route_name' => 'resumen.index',
                    'params' => [
                        'layout' => 'side-menu'
                    ],
                    'title' => 'Resumen'
                ],
                'chat' => [
                    'icon' => 'message-square',
                    'route_name' => 'resumen.reporteria',
                    'params' => [
                        'layout' => 'side-menu'
                    ],
                    'title' => 'Reportería'
                ],
                'pages' => [
                    'icon' => 'layout',
                    'route_name' => 'resumen.historico',
                    'params' => [
                        'layout' => 'side-menu'
                    ],
                    'title' => 'Histórico'
                ]
            ];
    }

    public static function menu_admin()
    {
            return [
                'dashboard' => [
                    'icon' => 'home',
                    'route_name' => 'dashboard.users',
                    'params' => [
                        'layout' => 'side-menu'
                    ],
                    'title' => 'Principal'
                ],
                /*'menu-layout' => [
                    'icon' => 'box',
                    'title' => 'Menu Layout',
                    'sub_menu' => [
                        'side-menu' => [
                            'icon' => '',
                            'route_name' => 'dashboard',
                            'params' => [
                                'layout' => 'side-menu'
                            ],
                            'title' => 'Side Menu'
                        ],
                        'simple-menu' => [
                            'icon' => '',
                            'route_name' => 'dashboard',
                            'params' => [
                                'layout' => 'simple-menu'
                            ],
                            'title' => 'Simple Menu'
                        ],
                        'top-menu' => [
                            'icon' => '',
                            'route_name' => 'dashboard',
                            'params' => [
                                'layout' => 'top-menu'
                            ],
                            'title' => 'Top Menu'
                        ]
                    ]
                ],*/
                'juegos' => [
                    'icon' => 'book',
                    'route_name' => 'juegos.index',
                    'params' => [
                        'layout' => 'side-menu'
                    ],
                    'title' => 'Juegos Hoy'
                ],
                'sorteos' => [
                    'icon' => 'book',
                    'route_name' => 'sorteos.index',
                    'params' => [
                        'layout' => 'side-menu'
                    ],
                    'title' => 'Sorteos'
                ],
                'resultados' => [
                    'icon' => 'layers',
                    'route_name' => 'resultados.index',
                    'params' => [
                        'layout' => 'side-menu'
                    ],
                    'title' => 'Carga Resultados'
                ],
                'transacciones' => [
                    'icon' => 'activity',
                    'route_name' => 'transacciones.index',
                    'params' => [
                        'layout' => 'side-menu'
                    ],
                    'title' => 'Transacciones'
                ],
                'cuentas' => [
                    'icon' => 'dollar-sign',
                    'route_name' => 'cuentas.index',
                    'params' => [
                        'layout' => 'side-menu'
                    ],
                    'title' => 'Cuentas Agentes'
                ],
                'clientes' => [
                    'icon' => 'users',
                    'route_name' => 'clientes.index',
                    'params' => [
                        'layout' => 'side-menu'
                    ],
                    'title' => 'Clientes'
                ],
                'usuarios' => [
                    'icon' => 'user-check',
                    'route_name' => 'user.index',
                    'params' => [
                        'layout' => 'side-menu'
                    ],
                    'title' => 'Usuarios'
                ]
            ];
    }
}
