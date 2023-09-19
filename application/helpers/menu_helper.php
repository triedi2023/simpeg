<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function buildMenu($menu_array, $is_sub = FALSE) {
    $attr = (!$is_sub) ? 'class="nav navbar-nav"' : 'class="dropdown-menu pull-left"';
    $menu = "<ul $attr>";

    $i = 1;
    $sub_menu = false;
    foreach ($menu_array as $id => $properties) {
        $sub = NULL;
        foreach ($properties as $key => $val) {
            if (is_array($val)) {
                $sub = buildMenu($val, TRUE);
                $sub_menu = true;
            } else {
                $sub = NULL;
                $$key = $val;
            }
        }

        $class = "";
        $classahref = "";
        if ($sub_menu) {
            if ($LVL == 1) {
                $class = 'class="menu-dropdown classic-menu-dropdown"';
            } else {
                if ($sub == NULL) {
                    $class = '';
                    $classahref = 'class="nav-link"';
                } else {
                    $class = 'class="dropdown-submenu"';
                    $classahref = 'class="nav-link nav-toggle"';
                }
            }
        } else {
            $class = "";
            if ($LVL > 1)
                $classahref = 'class="nav-link"';
        }

        if (strpos($URL_MENU,"http") === false) {
            $have_url = (!empty($URL_MENU)) ? '' . site_url($URL_MENU) . '' : 'javascript:;';
        } else {
            $have_url = $URL_MENU;
        }
        $menu .= "<li aria-haspopup=\"true\" $class><a $classahref href=\"" . $have_url . "\">" . $NAMA_MENU . "</a>$sub</li>";
        
        unset($url, $display, $sub);
        $i ++;
    }
    return $menu . "</ul>";
}
