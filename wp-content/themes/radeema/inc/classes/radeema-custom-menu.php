<?php
class Radeema_Custom_Nav_Walker extends Walker_Nav_Menu {

  function start_lvl(&$output, $depth = 0, $args = array()) {
    $output .= "\n<ul class=\"dropdown-menu\">\n";
 }

  function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
    $item_html = '';
    parent::start_el($item_html, $item, $depth, $args);

    if ( $item->is_dropdown ) {
        $item_html = str_replace( '<a', '<a class="dropdown-toggle nav-link" data-toggle="dropdown"', $item_html );
        //$item_html = str_replace( '</a>', ' <b class="caret"></b></a>', $item_html );
    }

    $output .= $item_html;
    }

    function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
        if ( $element->current )
        $element->classes[] = 'active';

        $element->is_dropdown = !empty( $children_elements[$element->ID] );

    	//var_dump($depth);
        if ( $element->is_dropdown ) {
            if ( $depth >= 0 ) {
                $element->classes[] = 'dropdown';
            }
        }
        if ( $depth >= 1 ) {
                // Extra level of dropdown menu, 
                // as seen in http://twitter.github.com/bootstrap/components.html#dropdowns
                $element->classes[] = 'dropdown-item';
            }

        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }
}