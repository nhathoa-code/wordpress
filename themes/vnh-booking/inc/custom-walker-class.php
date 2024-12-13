<?php

class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'nav-item';
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= '<li' . $class_names . '>';
        if (in_array('menu-item-has-children', $classes)) {
            $has_submenu = true;
        }else{
            $has_submenu = false;
        }

        $attributes = !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        $output .= '<a class="nav-link' . ($has_submenu ? ' dropdown-toggle"' : '"') . $attributes . '>';
        $output .= apply_filters('the_title', $item->title, $item->ID);
        $output .= '</a>';
    }

    function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat("\t", $depth);
        $submenu_class = $depth > 0 ? 'dropdown-menu' : 'dropdown-menu';
        $output .= "\n$indent<ul class=\"$submenu_class\">\n";
    }
}