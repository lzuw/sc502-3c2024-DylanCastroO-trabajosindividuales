<?php

$transacciones = [];

function registrarTransaccion(&$transacciones, $id, $descripcion, $monto) {
    $transaccion = [
        'id' => $id,
        'descripcion' => $descripcion,
        'monto' => $monto
    ];
    array_push($transacciones, $transaccion);
}

function generarEstadoDeCuenta($transacciones) {
    $montoTotal = 0;

    foreach ($transacciones as $transaccion) {
        $montoTotal += $transaccion['monto'];
    }

    $interes = 0.026;
    $montoConInteres = $montoTotal * (1 + $interes);
    $cashback = $montoTotal * 0.001;
    $montoFinal = $montoConInteres - $cashback;

    $linea = str_repeat("=", 55);
    $salida = "";
    $salida .= "$linea\n";
    $salida .= "         ESTADO DE CUENTA - TARJETA DE CRÉDITO\n";
    $salida .= "$linea\n\n";

    $salida .= "Detalle de Transacciones:\n";
    $salida .= str_repeat("-", 55) . "\n";
    $salida .= sprintf("%-5s %-30s %15s\n", "ID", "Descripción", "Monto (₡)");
    $salida .= str_repeat("-", 55) . "\n";

    foreach ($transacciones as $t) {
        $salida .= sprintf("%-5s %-30s %15s\n", $t['id'], $t['descripcion'], number_format($t['monto'], 2));
    }

    $salida .= str_repeat("-", 55) . "\n\n";

    $salida .= sprintf("Monto total de contado:        ₡ %s\n", number_format($montoTotal, 2));
    $salida .= sprintf("Interés aplicado (2.6%%):        ₡ %s\n", number_format($montoTotal * $interes, 2));
    $salida .= sprintf("Monto total con intereses:     ₡ %s\n", number_format($montoConInteres, 2));
    $salida .= sprintf("Cash back (0.1%%):              -₡ %s\n", number_format($cashback, 2));
    $salida .= "$linea\n";
    $salida .= sprintf("MONTO FINAL A PAGAR:           ₡ %s\n", number_format($montoFinal, 2));
    $salida .= "$linea\n";
    echo "<html>\n<head>\n";
    echo "<meta charset='UTF-8'>\n";
    echo "<title>Estado de Cuenta</title>\n";
    echo "<style>\n";
    echo "  body { font-family: 'Courier New', monospace; background: #f4f4f4; padding: 20px; }\n";
    echo "  .estado { background: white; padding: 30px; max-width: 650px; margin: auto; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }\n";
    echo "  pre { font-size: 14px; line-height: 1.6; }\n";
    echo "  h1 { text-align: center; color: #333; }\n";
    echo "  .info { text-align: center; color: #666; font-size: 13px; margin-top: 20px; }\n";
    echo "</style>\n";
    echo "</head>\n<body>\n";
    echo "<div class='estado'>\n";
    echo "<pre>" . htmlspecialchars($salida) . "</pre>\n";
    echo "<p class='info'>Este estado de cuenta también fue guardado en <strong>estado_cuenta.txt</strong></p>\n";
    echo "</div>\n";
    echo "</body>\n</html>\n";

    // Guardar en archivo de texto
    $archivo = __DIR__ . '/estado_cuenta.txt';
    file_put_contents($archivo, $salida);
}


registrarTransaccion($transacciones, 1, "Walmart", 45000.00);
registrarTransaccion($transacciones, 2, "Gasolinera", 22000.00);
registrarTransaccion($transacciones, 3, "Tacobell", 18500.00);
registrarTransaccion($transacciones, 4, "Sportlife", 12000.00);
registrarTransaccion($transacciones, 5, "Ekono", 35000.00);

generarEstadoDeCuenta($transacciones);
