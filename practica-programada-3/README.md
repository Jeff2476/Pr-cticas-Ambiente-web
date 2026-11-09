# Práctica Programada #3 - SC-502

Sistema en PHP que registra transacciones de una tarjeta de crédito y genera un estado de cuenta en pantalla y en un archivo de texto.

## Requisitos
- PHP 7.4 o superior.
- Navegador web.
- Servidor local como XAMPP, WAMP o el servidor integrado de PHP.

## Ejecución con XAMPP
1. Copiar la carpeta `practica-programada-3` dentro de `C:\\xampp\\htdocs\\`.
2. Iniciar Apache desde el panel de XAMPP.
3. Abrir `http://localhost/Pr-cticas-Ambiente-web/practica-programada-3/` en el navegador, si se clonó el repositorio dentro de htdocs.
4. El archivo `estado_cuenta.txt` se genera automáticamente en esta misma carpeta.

## Requisitos implementados
- Arreglo `$transacciones` con `id`, `descripcion` y `monto`.
- Función `registrarTransaccion($id, $descripcion, $monto)`.
- Función `generarEstadoDeCuenta()`.
- Cálculo del interés del 2.6%.
- Cálculo del cashback del 0.1% sobre el monto de contado.
- Visualización del estado de cuenta.
- Generación del archivo `estado_cuenta.txt`.

## Cálculo utilizado
- Total con interés = total de contado × 1.026
- Cashback = total de contado × 0.001
- Monto final = total con interés − cashback
