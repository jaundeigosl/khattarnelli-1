<?php

include "../../paths.php";
include "../../controladores/carritoController.php";
include "../../templates/header.php";
include "../../components/nav.php";
require_once __DIR__ . '/../../app/Shipping/ShippingService.php';

$shipping = new ShippingService();
$cantidad_total = obtener_total_carrito();
$economico_disponible = $shipping->envioEconomicoDisponible($cantidad_total);
?>



<style>
/* ============================
   CART PAGE - ESTILO PROFESIONAL OPTIMIZADO
   ============================ */

.cart-page__container {
    width: 100%;
    padding: 0 15px; 
    margin: 0 auto; 
    max-width: 1400px; 
}

.cart-layout {
    display: grid;
    grid-template-columns: 2fr 1.5fr 1.5fr;
    gap: 20px;
    margin-top: 25px;
}

@media (max-width: 1200px) {
    .cart-layout {
        grid-template-columns: 1fr 1fr;
    }
    .cart-layout > .card-box:last-child {
        grid-column: 1 / -1;
    }
}

@media (max-width: 768px) { 
    .cart-layout {
        grid-template-columns: 1fr;
    }
}

/* --- TARJETAS (GLASSMORPHISM) --- */
.card-box {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    padding: 18px;
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.18);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.25);
}

.cart-page__title {
    font-size: 26px;
    margin-bottom: 15px;
    color: #fff;
}

/* Textos */
.cart-page__empty,
.shipping-title,
.summary-title,
.cart-table th,
.cart-table td,
.cart-table__name,
.card-box label {
    color: #ffffff;
    font-weight: 300;
}

/* Inputs */
.form-control {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    background: rgba(255, 255, 255, 0.13);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 4px;
    font-size: 14px;
    color: #fff;
}

.form-control::placeholder {
    color: #ddd;
}

/* Labels */
.card-box label {
    font-size: 14px;
    margin-bottom: 3px;
}

/* Subtítulos */
.shipping-title,
.summary-title {
    font-size: 18px;
    margin-bottom: 10px;
    font-weight: 500;
}

/* Total */
.summary-total {
    font-size: 20px;
    margin-bottom: 15px;
    font-weight: 600;
    color: #fff;
}

/* Opciones de envío */
.shipping-option {
    display: flex;
    gap: 8px;
    margin-bottom: 8px;
    font-size: 14px;
    background: rgba(255, 255, 255, 0.08);
    padding: 8px 10px;
    border-radius: 6px;
    align-items: center;
}

.shipping-option input {
    transform: scale(1.1);
}

.shipping-option small {
    margin-left: 22px;
    font-size: 12px;
    color: #eee;
}

/* Tabla */
.cart-table__wrap {
    overflow-x: auto;
    border-radius: 10px;
}

.cart-table {
    width: 100%;
    border-collapse: collapse;
}

.cart-table th {
    padding-bottom: 8px;
    font-size: 14px;
    font-weight: 500;
}

.cart-table td {
    padding: 10px 0;
    font-size: 14px;
}

.cart-table__img {
    width: 52px;
    height: 52px;
    border-radius: 6px;
    object-fit: cover;
    margin-right: 8px;
}

.cart-table__product {
    display: flex;
    align-items: center;
    gap: 6px;
}

/* Botones */
.cart-buttons {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-top: 15px;
}

.btn-pagar {
    padding: 12px 16px;
    border-radius: 6px;
    font-size: 15px;
    color: white;
    font-weight: 600;
    border: none;
    cursor: pointer;
    width: 100%;
    transition: 0.2s ease-in-out;
}

.btn-pagar:hover {
    opacity: 0.85;
}

.btn-vaciar {
    text-align: center;
    background: rgba(255, 255, 255, 0.08);
    padding: 12px 16px;
    border-radius: 6px;
    font-size: 15px;
    font-weight: 600;
    color: white;
    display: block;
    transition: .2s;
}

.btn-vaciar:hover {
    background: rgba(255, 255, 255, 0.15);
}

/* Eliminar */
.btn-eliminar {
    color: #ff6b6b;
    text-decoration: none;
    font-weight: 600;
}
</style>

<?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
    <div class="alert alert-success">
        🎉 ¡Pago realizado con éxito! Gracias por tu compra.
    </div>
<?php endif; ?>

<div class="cart-page__container">

    <h1 class="cart-page__title">Carrito de Compras</h1>

    <?php if (empty($_SESSION['carrito'])): ?>
        
        <p class="cart-page__empty">Tu carrito está vacío.</p>

    <?php else: ?>

        <div class="cart-layout">

    <!-- COLUMNA 1: TABLA -->
    <div class="card-box">
        <div class="card-box"> 
            <div class="cart-table__wrap"> 
                <table class="cart-table"> 
                    <thead>
                         <tr> 
                            <th>Producto</th>
                             <th>Precio</th>
                              <th>Cant</th>
                               <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                         <tbody>
                             <?php $gran_total = 0; foreach ($_SESSION['carrito'] as $p): $subtotal = $p['precio'] * $p['cantidad']; $gran_total += $subtotal; ?> 
                             <tr> 
                                <td class="cart-table__product">
                                     <img src="<?= BASE_URL . $p['imagen']; ?>" class="cart-table__img">
                                      <span class="cart-table__name"><?= htmlspecialchars($p['nombre']); ?></span>
                                </td> 
                                <td>$<?= number_format($p['precio'],2); ?></td>
                                <td><?= $p['cantidad']; ?></td> 
                                <td>$<?= number_format($subtotal,2); ?></td> 
                                <td> <a class="btn-eliminar" href="remove.php?id=<?= $p['id']; ?>">Eliminar</a> </td>
                             </tr> <?php endforeach; ?> 
                        </tbody> 
                    </table> 
                </div> 
            </div>
    </div>

    <!-- COLUMNA 2: FORMULARIO -->
    <div class="card-box">
        <form id="customer-info-form">
            <h3>Datos del Cliente</h3>

            <label for="nombre_cliente">Nombre completo *</label>
            <input type="text" name="nombre_cliente" id="nombre_cliente" required class="form-control">

            <label for="correo_cliente">Correo *</label>
            <input type="email" name="correo_cliente" id="correo_cliente" required class="form-control">

            <label for="telefono_cliente">Teléfono *</label>
            <input type="text" name="telefono_cliente" id="telefono_cliente" required class="form-control">

            <label for="ubicacion_cliente">Dirección *</label>
            <textarea name="ubicacion_cliente" id="ubicacion_cliente" required class="form-control"></textarea>
        </form>
    </div>

    <!-- COLUMNA 3: MÉTODO DE ENVÍO + PAGO -->
    <div class="card-box">
        <form id="shipping-payment-form" method="POST" onsubmit="return validateForm()">

            <div class="shipping-title">Opciones de Envío</div>

            <label class="shipping-option">
                <input type="radio" name="envio" value="normal" checked>
                Envío Normal —
                <strong>
                        <?php 
                        if ($cantidad_total > 50) {
                            echo "Gratis";
                        } elseif ($cantidad_total >= 10) {
                            echo "$99 MXN";
                        } else {
                            echo "$189 MXN";
                        }
                        ?>
                </strong>
            </label>

            <label class="shipping-option" style="opacity:<?= $economico_disponible ? '1' : '0.5'; ?>;">
                <input type="radio" name="envio" value="economico" <?= $economico_disponible ? '' : 'disabled'; ?>>
                Envío Económico — <strong>$89 MXN</strong> (10–20 días)
                <?php if (!$economico_disponible): ?>
                    <small>Solo disponible de 1 a 10 paquetes.</small>
                <?php endif; ?>
            </label>

            <div class="summary-title">Resumen</div>
            <div class="summary-total">Total: $<?= number_format($gran_total, 2); ?></div>

            <div class="cart-buttons">
                <button type="submit" formaction="../pago/checkout.php" class="btn-pagar" style="background:#0070ba;">
                    Pagar con PayPal
                </button>

                <button type="submit" formaction="../pago/stripe_checkout.php" class="btn-pagar" style="background:#635bff;">
                    Pagar con Stripe
                </button>

                <a href="vaciar.php" class="btn-vaciar">Vaciar carrito</a>
            </div>

        </form>
    </div>

</div>


</form>

            
        </div>
        <?php endif; ?>

</div>

<script>
    function validateForm() {
        const form = document.getElementById('customer-info-form');
        
        // 1. Validar que los campos de Datos del Cliente estén llenos
        if (!form.checkValidity()) {
            alert('🚨 Por favor, complete todos los campos requeridos en la sección "Datos del Cliente" antes de proceder al pago.');
            
            // Si la validación falla, hacemos un pequeño "scroll" a la sección del formulario
            document.getElementById('nombre_cliente').scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            // Devolvemos false para detener el envío del formulario de pago
            return false;
        }

        // 2. Si es válido, podemos copiar los datos del formulario de info al de pago (o enviarlos por separado en una implementación real)
        // Para este ejemplo simple, solo validamos y dejamos que el formulario de pago se envíe.
        
        return true; // Permitir el envío del formulario de pago
    }
</script>

<?php include "../../templates/footer.php"; ?>