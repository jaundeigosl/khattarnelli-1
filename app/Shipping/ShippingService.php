<?php

class ShippingService {

    /**
     * Calcula el costo de envío según reglas.
     *
     * @param int $cantidad Total de paquetes en el carrito.
     * @param string $tipo Tipo de envío: normal | economico
     * @return float Costo del envío.
     */
    public function calcularEnvio(int $cantidad, string $tipo = 'normal'): float
    {
        if ($cantidad <= 0) {
            return 0;
        }

        // Validación extra: envío económico solo aplica entre 1 y 10 paquetes
        if ($tipo === 'economico') {
            if ($cantidad >= 1 && $cantidad <= 10) {
                return 89; // MXN
            } else {
                // Si no aplica, se fuerza a normal
                return $this->calcularEnvio($cantidad, 'normal');
            }
        }

        // --- Envío normal ---
        if ($cantidad >= 50) {
            return 0; // Gratis
        } elseif ($cantidad >= 10) {
            return 99;
        } else {
            return 189;
        }
    }

    /**
     * Verifica si el envío económico está permitido.
     */
    public function envioEconomicoDisponible(int $cantidad): bool
    {
        return ($cantidad >= 1 && $cantidad <= 10);
    }
}
