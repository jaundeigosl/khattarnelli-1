<?php

require_once __DIR__ . '/../modelos/modelo_pedidos.php';

class PedidosController {

    public function listar() {
        return obtener_todos_los_pedidos();
    }
}
