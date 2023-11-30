<?php
/**
 * Plugin Name: Facturación por Porcentajes
 * Description: Plugin personalizado para mostrar una barra de progreso por porcentajes según los niveles de facturación mes a mes.
 * Version: 1.1
 * Author: Alejandro Lamas
 */

defined('ABSPATH') or die('Acceso denegado');

// Include necessary files
require_once plugin_dir_path(__FILE__) . 'includes/admin-page.php';
require_once plugin_dir_path(__FILE__) . 'includes/shortcode.php';

// Enqueue styles and scripts
function fpp_enqueue_scripts() {
    wp_enqueue_style('fpp-style', plugins_url('css/style.css', __FILE__));
    wp_enqueue_script('fpp-script', plugins_url('js/script.js', __FILE__), array('jquery'), null, true);
}

add_action('wp_enqueue_scripts', 'fpp_enqueue_scripts');
