<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Main\TopMenu;
use App\Main\SideMenu;
use App\Main\SimpleMenu;
use Illuminate\Support\Facades\Auth;

class MenuComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if (!is_null(request()->route())) {
            $pageName = request()->route()->getName();
            $layout = $this->layout($view);
            $activeMenu = $this->activeMenu($pageName, $layout);
            if (!is_null(Auth::user()) and Auth::user()->es_administrador == 0) {

                $view->with('top_menu', TopMenu::menu());
                $view->with('side_menu', SideMenu::menu());
                $view->with('simple_menu', SimpleMenu::menu());
                $view->with('first_level_active_index', $activeMenu['first_level_active_index']);
                $view->with('second_level_active_index', $activeMenu['second_level_active_index']);
                $view->with('third_level_active_index', $activeMenu['third_level_active_index']);
                $view->with('page_name', $pageName);
                $view->with('layout', $layout);

            } else {
                $view->with('top_menu', TopMenu::menu_admin());
                $view->with('side_menu', SideMenu::menu_admin());
                $view->with('simple_menu', SimpleMenu::menu_admin());
                $view->with('first_level_active_index', $activeMenu['first_level_active_index']);
                $view->with('second_level_active_index', $activeMenu['second_level_active_index']);
                $view->with('third_level_active_index', $activeMenu['third_level_active_index']);
                $view->with('page_name', $pageName);
                $view->with('layout', $layout);
            }
        }
    }
    public function layout($view)
    {
        if (isset($view->layout)) {
            return $view->layout;
        } else if (request()->has('layout')) {
            return request()->query('layout');
        }

        return 'top-menu';
    }

    public function activeMenu($pageName, $layout)
    {
        $firstLevelActiveIndex = '';
        $secondLevelActiveIndex = '';
        $thirdLevelActiveIndex = '';


        if ($layout == 'top-menu') {
            // Validacion para saber si es administrador y cambiar la funcion interna de la clase del menu
            if (!is_null(Auth::user()) and Auth::user()->es_administrador == 0) {

                foreach (TopMenu::menu() as $menuKey => $menu) {
                    if (isset($menu['route_name']) && $menu['route_name'] == $pageName && empty($firstPageName)) {
                        $firstLevelActiveIndex = $menuKey;
                    }

                    if (isset($menu['sub_menu'])) {
                        foreach ($menu['sub_menu'] as $subMenuKey => $subMenu) {
                            if (isset($subMenu['route_name']) && $subMenu['route_name'] == $pageName && $menuKey != 'menu-layout' && empty($secondPageName)) {
                                $firstLevelActiveIndex = $menuKey;
                                $secondLevelActiveIndex = $subMenuKey;
                            }

                            if (isset($subMenu['sub_menu'])) {
                                foreach ($subMenu['sub_menu'] as $lastSubMenuKey => $lastSubMenu) {
                                    if (isset($lastSubMenu['route_name']) && $lastSubMenu['route_name'] == $pageName) {
                                        $firstLevelActiveIndex = $menuKey;
                                        $secondLevelActiveIndex = $subMenuKey;
                                        $thirdLevelActiveIndex = $lastSubMenuKey;
                                    }
                                }
                            }
                        }
                    }
                }
            } else {

                foreach (TopMenu::menu_admin() as $menuKey => $menu) {
                        if (isset($menu['route_name']) && $menu['route_name'] == $pageName && empty($firstPageName)) {
                            $firstLevelActiveIndex = $menuKey;
                        }



                    if (isset($menu['sub_menu'])) {
                        foreach ($menu['sub_menu'] as $subMenuKey => $subMenu) {
                            if (isset($subMenu['route_name']) && $subMenu['route_name'] == $pageName && $menuKey != 'menu-layout' && empty($secondPageName)) {
                                $firstLevelActiveIndex = $menuKey;
                                $secondLevelActiveIndex = $subMenuKey;
                            }

                            if (isset($subMenu['sub_menu'])) {
                                foreach ($subMenu['sub_menu'] as $lastSubMenuKey => $lastSubMenu) {
                                    if (isset($lastSubMenu['route_name']) && $lastSubMenu['route_name'] == $pageName) {
                                        $firstLevelActiveIndex = $menuKey;
                                        $secondLevelActiveIndex = $subMenuKey;
                                        $thirdLevelActiveIndex = $lastSubMenuKey;
                                    }
                                }
                            }
                        }
                    }
                }
            }

        } else if ($layout == 'simple-menu') {

            if (Auth::user()->es_administrador == 0) {

                foreach (SimpleMenu::menu() as $menuKey => $menu) {
                    if ($menu !== 'devider' && isset($menu['route_name']) && $menu['route_name'] == $pageName && empty($firstPageName)) {
                        $firstLevelActiveIndex = $menuKey;
                    }

                    if (isset($menu['sub_menu'])) {
                        foreach ($menu['sub_menu'] as $subMenuKey => $subMenu) {
                            if (isset($subMenu['route_name']) && $subMenu['route_name'] == $pageName && $menuKey != 'menu-layout' && empty($secondPageName)) {
                                $firstLevelActiveIndex = $menuKey;
                                $secondLevelActiveIndex = $subMenuKey;
                            }

                            if (isset($subMenu['sub_menu'])) {
                                foreach ($subMenu['sub_menu'] as $lastSubMenuKey => $lastSubMenu) {
                                    if (isset($lastSubMenu['route_name']) && $lastSubMenu['route_name'] == $pageName) {
                                        $firstLevelActiveIndex = $menuKey;
                                        $secondLevelActiveIndex = $subMenuKey;
                                        $thirdLevelActiveIndex = $lastSubMenuKey;
                                    }
                                }
                            }
                        }
                    }
                }

            } else {

                foreach (SimpleMenu::menu_admin() as $menuKey => $menu) {
                    if ($menu !== 'devider' && isset($menu['route_name']) && $menu['route_name'] == $pageName && empty($firstPageName)) {
                        $firstLevelActiveIndex = $menuKey;
                    }

                    if (isset($menu['sub_menu'])) {
                        foreach ($menu['sub_menu'] as $subMenuKey => $subMenu) {
                            if (isset($subMenu['route_name']) && $subMenu['route_name'] == $pageName && $menuKey != 'menu-layout' && empty($secondPageName)) {
                                $firstLevelActiveIndex = $menuKey;
                                $secondLevelActiveIndex = $subMenuKey;
                            }

                            if (isset($subMenu['sub_menu'])) {
                                foreach ($subMenu['sub_menu'] as $lastSubMenuKey => $lastSubMenu) {
                                    if (isset($lastSubMenu['route_name']) && $lastSubMenu['route_name'] == $pageName) {
                                        $firstLevelActiveIndex = $menuKey;
                                        $secondLevelActiveIndex = $subMenuKey;
                                        $thirdLevelActiveIndex = $lastSubMenuKey;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {

            if (!is_null(Auth::user()) and Auth::user()->es_administrador == 0) {

                foreach (SideMenu::menu() as $menuKey => $menu) {
                    if ($menu !== 'devider' && isset($menu['route_name']) && $menu['route_name'] == $pageName && empty($firstPageName)) {
                        $firstLevelActiveIndex = $menuKey;
                    }

                    if (isset($menu['sub_menu'])) {
                        foreach ($menu['sub_menu'] as $subMenuKey => $subMenu) {
                            if (isset($subMenu['route_name']) && $subMenu['route_name'] == $pageName && $menuKey != 'menu-layout' && empty($secondPageName)) {
                                $firstLevelActiveIndex = $menuKey;
                                $secondLevelActiveIndex = $subMenuKey;
                            }

                            if (isset($subMenu['sub_menu'])) {
                                foreach ($subMenu['sub_menu'] as $lastSubMenuKey => $lastSubMenu) {
                                    if (isset($lastSubMenu['route_name']) && $lastSubMenu['route_name'] == $pageName) {
                                        $firstLevelActiveIndex = $menuKey;
                                        $secondLevelActiveIndex = $subMenuKey;
                                        $thirdLevelActiveIndex = $lastSubMenuKey;
                                    }
                                }
                            }
                        }
                    }
                }
            } else {

                foreach (SideMenu::menu_admin() as $menuKey => $menu) {
                    if ($menu !== 'devider' && isset($menu['route_name']) && $menu['route_name'] == $pageName && empty($firstPageName)) {
                        $firstLevelActiveIndex = $menuKey;
                    }

                    if (isset($menu['sub_menu'])) {
                        foreach ($menu['sub_menu'] as $subMenuKey => $subMenu) {
                            if (isset($subMenu['route_name']) && $subMenu['route_name'] == $pageName && $menuKey != 'menu-layout' && empty($secondPageName)) {
                                $firstLevelActiveIndex = $menuKey;
                                $secondLevelActiveIndex = $subMenuKey;
                            }

                            if (isset($subMenu['sub_menu'])) {
                                foreach ($subMenu['sub_menu'] as $lastSubMenuKey => $lastSubMenu) {
                                    if (isset($lastSubMenu['route_name']) && $lastSubMenu['route_name'] == $pageName) {
                                        $firstLevelActiveIndex = $menuKey;
                                        $secondLevelActiveIndex = $subMenuKey;
                                        $thirdLevelActiveIndex = $lastSubMenuKey;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return [
            'first_level_active_index' => $firstLevelActiveIndex,
            'second_level_active_index' => $secondLevelActiveIndex,
            'third_level_active_index' => $thirdLevelActiveIndex
        ];
    }
}
