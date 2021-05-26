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
            'name' => __( 'small', 'gm-starter-theme' ),
            'shortName' => __( 'S', 'gm-starter-theme' ),
            'size' => 12,
            'slug' => 'small'
        ),
        array(
            'name' => __( 'regular', 'gm-starter-theme' ),
            'shortName' => __( 'M', 'gm-starter-theme' ),
            'size' => 16,
            'slug' => 'regular'
        ),
        array(
            'name' => __( 'large', 'gm-starter-theme' ),
            'shortName' => __( 'L', 'gm-starter-theme' ),
            'size' => 36,
            'slug' => 'large'
        ),
        array(
            'name' => __( 'larger', 'gm-starter-theme' ),
            'shortName' => __( 'XL', 'gm-starter-theme' ),
            'size' => 50,
            'slug' => 'larger'
        )
    ) );

    add_theme_support( 'editor-color-palette',
        array(
            array( 'name' => 'blue', 'slug'  => 'blue', 'color' => '#48ADD8' ),
            array( 'name' => 'pink', 'slug'  => 'pink', 'color' => '#FF2952' ),
            array( 'name' => 'green', 'slug'  => 'green', 'color' => '#83BD71' ),
        )
    );

    add_theme_support( 'editor-gradient-presets', []);

    add_theme_support( 'disable-custom-colors' );
    add_theme_support( 'disable-custom-gradients' );
    add_theme_support( 'disable-custom-font-sizes' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'responsive-embeds' );
}



add_action( 'init', __NAMESPACE__ . '\gutenberg_css' );
add_action( 'init', __NAMESPACE__ . '\gutenberg_settings' );
