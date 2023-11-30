<?php
// Archivo: /facturacion-por-porcentajes/includes/admin-page.php

// Hook para agregar menús de administrador
add_action('admin_menu', 'fpp_admin_menu');

// Función de acción para agregar menús de administrador
function fpp_admin_menu() {
    add_menu_page(
        'Facturación por Porcentajes',
        'Facturación Porcentajes',
        'manage_options',
        'facturacion-por-porcentajes',
        'fpp_admin_page'
    );
}

// Contenido de la página de administración
function fpp_admin_page() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Verifica que se haya enviado el formulario y actualiza las opciones
        update_option('fpp_first_level', sanitize_text_field($_POST['first_level']));
        update_option('fpp_second_level', sanitize_text_field($_POST['second_level']));
        update_option('fpp_third_level', sanitize_text_field($_POST['third_level']));
        update_option('fpp_fourth_level', sanitize_text_field($_POST['fourth_level']));
    }

    // Obtiene los valores actuales de los niveles de facturación
    $first_level = get_option('fpp_first_level', 0);
    $second_level = get_option('fpp_second_level', 0);
    $third_level = get_option('fpp_third_level', 0);
    $fourth_level = get_option('fpp_fourth_level', 0);
    ?>
    <div class="wrap">
        <h2>Configuración de Facturación por Porcentajes</h2>
        <form method="post" action="">
            <label for="first_level">Primer Nivel:</label>
            <input type="text" name="first_level" id="first_level" value="<?php echo esc_attr($first_level); ?>" />

            <label for="second_level">Segundo Nivel:</label>
            <input type="text" name="second_level" id="second_level" value="<?php echo esc_attr($second_level); ?>" />

            <label for="third_level">Tercer Nivel:</label>
            <input type="text" name="third_level" id="third_level" value="<?php echo esc_attr($third_level); ?>" />

            <label for="fourth_level">Cuarto Nivel:</label>
            <input type="text" name="fourth_level" id="fourth_level" value="<?php echo esc_attr($fourth_level); ?>" />

            <?php submit_button('Guardar Configuración'); ?>
        </form>
    </div>
    <?php
}
