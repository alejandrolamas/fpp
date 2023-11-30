<?php
// Archivo: /facturacion-por-porcentajes/includes/shortcode.php

// Shortcode para mostrar la barra de progreso
function fpp_progress_bar_shortcode() {
    // Calcula el porcentaje en base a los niveles de facturación y la facturación mensual actual
    $percentage = calculate_percentage();

    // Genera el HTML de la barra de progreso
    ob_start();
    ?>
    <div class="fpp-progress-bar">
        <div class="fpp-progress <?php echo 'fpp-progress-' . $percentage; ?>" style="width: <?php echo esc_attr($percentage); ?>%;"><?php echo round(esc_attr($percentage),2); ?>%</div>
        <div class="fpp-labels" style="    max-width: 100%;display: flex;justify-content: space-between;">
            <span class="fpp-label">0%</span>
            <span class="fpp-label">25%</span>
            <span class="fpp-label">50%</span>
            <span class="fpp-label">75%</span>
            <span class="fpp-label">100%</span>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

// Registra el shortcode
add_shortcode('fpp_progress_bar', 'fpp_progress_bar_shortcode');

// Lógica para calcular el porcentaje (debes implementar esta función según tus datos)
function calculate_percentage() {
    // Obtén los valores de los niveles de facturación
    $first_level = get_option('fpp_first_level', 0);
    $second_level = get_option('fpp_second_level', 0);
    $third_level = get_option('fpp_third_level', 0);
    $fourth_level = get_option('fpp_fourth_level', 0);

    // Obtén la facturación mensual actual
    $monthly_billing = get_current_month_billing();

    // Si no hay facturación, el porcentaje es 0%
    if (empty($monthly_billing)) {
        return 0;
    }

    // Inicializa el total de la facturación mensual
    $total_billing = 0;

    // Suma los totales de todos los pedidos
    foreach ($monthly_billing as $order) {
        $total_billing += $order->get_data()['total'];
    }

    // Calcula el porcentaje
    if ($total_billing < $first_level) {
        $percentage = 25 * ($total_billing / $first_level);
    } elseif ($total_billing < $second_level) {
        $percentage = 25 + 25 * (($total_billing - $first_level) / ($second_level - $first_level));
    } elseif ($total_billing < $third_level) {
        $percentage = 50 + 25 * (($total_billing - $second_level) / ($third_level - $second_level));
    } elseif ($total_billing < $fourth_level) {
        $percentage = 75 + 25 * (($total_billing - $third_level) / ($fourth_level - $third_level));
    } else {
        $percentage = 100;
    }

    return $percentage;
}


// Función para obtener la facturación mensual actual con WooCommerce
function get_current_month_billing() {
    if (class_exists('WooCommerce')) {
        $start_of_month = date('Y-m-01 00:00:00');
        $current_date = current_time('mysql');

        $order_total = wc_get_orders(array(
            'status'        => 'completed',
            'date_created'  => '>=' . strtotime($start_of_month),
            'date_created'  => '<=' . strtotime($current_date),
            'type'          => 'shop_order',
            'return'        => 'total',
        ));

        return $order_total;
    } else {
        return 0;
    }
}
