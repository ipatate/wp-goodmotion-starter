<?php

namespace GoodmotionStarter\inc\editor;


/**
 * add style for gutenberg editor block
 */
function gutenberg_css(){

    add_theme_support( 'editor-styles' );
    add_editor_style( 'style-editor.css' );

}


function gutenberg_settings() {
    add_theme_support( 'editor-font-sizes', array(
        array(
            'name' => __( 'regular', 'gm-starter-theme' ),
            'shortName' => __( 'M', 'gm-starter-theme' ),
            'size' => '1rem',
            'slug' => 'regular'
        ),
    ) );

    add_theme_support( 'editor-color-palette',
        array(
            array( 'name' => 'accent', 'slug'  => 'accent', 'color' => '#450B40' ),
        )
    );

    add_theme_support( 'editor-gradient-presets', []);

    add_theme_support( 'disable-custom-colors' );
    add_theme_support( 'disable-custom-gradients' );
    add_theme_support( 'disable-custom-font-sizes' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'core-block-patterns' );
    add_theme_support( 'responsive-embeds' );
//    add_theme_support( 'custom-line-height' );
    add_theme_support('disable-custom-font-sizes');
    add_theme_support( 'wp-block-styles' );
}



add_action( 'init', __NAMESPACE__ . '\gutenberg_css' );
add_action( 'init', __NAMESPACE__ . '\gutenberg_settings' );
