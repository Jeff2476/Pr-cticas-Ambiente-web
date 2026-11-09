<?php
// Práctica Programada #3 - SC-502 Ambiente Web Cliente/Servidor

$transacciones = [];

function registrarTransaccion($id, $descripcion, $monto) {
    global $transacciones;
    $transacciones[] = ["id" => $id, "descripcion" => $descripcion, "monto" => (float) $monto];
}

function generarEstadoDeCuenta() {
    global $transacciones;
    $totalContado = 0;
    foreach ($transacciones as $transaccion) {
        $totalContado += $transaccion["monto"];
    }
    $totalConInteres = $totalContado * 1.026;
    $cashback = $totalContado * 0.001;
    $montoFinal = $totalConInteres - $cashback;

    $lineas = ["ESTADO DE CUENTA - TARJETA DE CREDITO", str_repeat("=", 48), ""];
    foreach ($transacciones as $transaccion) {
        $lineas[] = "Transaccion #" . $transaccion["id"];
        $lineas[] = "Descripcion: " . $transaccion["descripcion"];
        $lineas[] = "Monto: " . number_format($transaccion["monto"], 2, ".", ",");
        $lineas[] = str_repeat("-", 48);
    }
    $lineas[] = "";
    $lineas[] = "Total de contado:        " . number_format($totalContado, 2, ".", ",");
    $lineas[] = "Total con interes (2.6%): " . number_format($totalConInteres, 2, ".", ",");
    $lineas[] = "Cashback (0.1%):         -" . number_format($cashback, 2, ".", ",");
    $lineas[] = str_repeat("=", 48);
    $lineas[] = "MONTO FINAL A PAGAR:     " . number_format($montoFinal, 2, ".", ",");
    $lineas[] = "";
    $lineas[] = "El cashback se descuenta del total con intereses.";
    file_put_contents(__DIR__ . "/estado_cuenta.txt", implode(PHP_EOL, $lineas));
    return ["totalContado" => $totalContado, "totalConInteres" => $totalConInteres, "cashback" => $cashback, "montoFinal" => $montoFinal];
}

// Simulacion de transacciones
registrarTransaccion(1, "Compra de supermercado", 32500);
registrarTransaccion(2, "Combustible", 18000);
registrarTransaccion(3, "Pago de servicio de internet", 25000);
registrarTransaccion(4, "Compra de articulos personales", 12750);
registrarTransaccion(5, "Cena en restaurante", 14500);

$resumen = generarEstadoDeCuenta();
function escapar($valor) { return htmlspecialchars((string) $valor, ENT_QUOTES, "UTF-8"); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Estado de cuenta | Práctica 3</title>
<style>
*{box-sizing:border-box}body{margin:0;padding:35px 18px;font-family:Arial,Helvetica,sans-serif;background:#f2f5f9;color:#202938}.contenedor{max-width:900px;margin:auto;background:#fff;border-radius:14px;overflow:hidden;box-shadow:0 8px 28px rgba(25,40,65,.09)}header{padding:28px 32px;background:#183b65;color:white}header h1{margin:0 0 8px;font-size:25px}header p{margin:0;color:#dce8f5;font-size:14px}main{padding:28px 32px 32px}h2{margin:0 0 18px;font-size:19px}table{width:100%;border-collapse:collapse;margin-bottom:28px}th,td{padding:13px 12px;text-align:left;border-bottom:1px solid #e8edf3}th{background:#f5f7fa;color:#536174;font-size:13px}td{font-size:14px}.monto{text-align:right;white-space:nowrap}.resumen{max-width:470px;margin-left:auto;padding:20px;background:#f6f8fb;border-radius:10px}.fila{display:flex;justify-content:space-between;gap:16px;padding:10px 0;border-bottom:1px solid #e3e9f0;font-size:14px}.fila strong{text-align:right}.fila.final{border:0;padding-top:17px;margin-top:5px;color:#183b65;font-size:18px}.cashback{color:#16834b}.nota{color:#667386;font-size:12px;margin:16px 0 0}.acciones{margin-top:25px;display:flex;gap:10px;flex-wrap:wrap}.boton{display:inline-block;padding:11px 16px;border-radius:7px;text-decoration:none;font-size:14px;font-weight:bold;background:#183b65;color:white}.boton.secundario{background:#e8eef5;color:#183b65}footer{padding:17px 32px;background:#fafbfd;color:#7b8796;font-size:12px}@media(max-width:600px){body{padding:12px}header,main{padding:22px 18px}th,td{padding:10px 7px;font-size:12px}.resumen{max-width:none}}
</style>
</head>
<body><div class="contenedor">
<header><h1>Estado de cuenta</h1><p>Práctica Programada #3 · SC-502 Ambiente Web Cliente/Servidor</p></header>
<main><h2>Detalle de transacciones</h2>
<table><thead><tr><th>ID</th><th>Descripción</th><th class="monto">Monto (₡)</th></tr></thead><tbody>
<?php foreach ($transacciones as $transaccion): ?><tr><td><?= escapar($transaccion["id"]) ?></td><td><?= escapar($transaccion["descripcion"]) ?></td><td class="monto"><?= number_format($transaccion["monto"], 2, ",", ".") ?></td></tr><?php endforeach; ?>
</tbody></table>
<h2>Resumen de cuenta</h2><section class="resumen">
<div class="fila"><span>Total de contado</span><strong>₡<?= number_format($resumen["totalContado"], 2, ",", ".") ?></strong></div>
<div class="fila"><span>Total con interés (2.6%)</span><strong>₡<?= number_format($resumen["totalConInteres"], 2, ",", ".") ?></strong></div>
<div class="fila"><span>Cashback (0.1%)</span><strong class="cashback">−₡<?= number_format($resumen["cashback"], 2, ",", ".") ?></strong></div>
<div class="fila final"><span><strong>Monto final a pagar</strong></span><strong>₡<?= number_format($resumen["montoFinal"], 2, ",", ".") ?></strong></div>
<p class="nota">El cashback se calcula sobre el monto de contado y se resta del total con intereses.</p></section>
<div class="acciones"><a class="boton" href="estado_cuenta.txt" download>Descargar estado de cuenta</a><a class="boton secundario" href="index.php">Actualizar estado</a></div></main>
<footer>Archivo estado_cuenta.txt generado automáticamente al cargar esta página.</footer>
</div></body></html>
