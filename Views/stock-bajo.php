<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Bajo - Panadería Santizo</title>

    <!-- Bootstrap local -->
    <link rel="stylesheet" href="../../Bootstrap.css">
    <script src="../../Bootstrap.js"></script>

    <!-- Iconos -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Vue -->
    <script src="../../vue3.js"></script>
    <script defer src="../stock-bajo.js"></script>

    <style>
        body {
            background: #f4f6f9;
            font-family: 'Inter', sans-serif;
        }

        /* NAVBAR */
        .navbar-pan {
            background: linear-gradient(90deg, #C67C3B, #AA632B);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        /* SIDEBAR */
        .sidebar {
            background: #fff;
            border-right: 1px solid #e5e7eb;
            border-radius: 1rem;
            margin-top: 1rem;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        }

        .sidebar .nav-link {
            color: #555;
            border-radius: 8px;
            transition: 0.2s;
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background: #C67C3B;
            color: #fff;
        }

        .product-img {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 8px;
        }

        .table-hover tbody tr:hover {
            background: #fff5e6;
        }

        .card-stats {
            border: none;
            border-radius: 1rem;
            transition: transform 0.2s;
        }

        .card-stats:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        }

        .table-container {
            max-height: 420px;
            overflow-y: auto;
            overflow-x: hidden;
            border-radius: 10px;
        }

        /* Modal tamaño intermedio */
        .modal-dialog {
            max-width: 850px !important;
        }

        .modal-header {
            background-color: #C67C3B;
            color: white;
        }

        .Logo {
            height: 55%;
            width: 55%;
        }

        .spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Nuevos estilos para imagen en modal */
        .image-preview {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px dashed #dee2e6;
            display: block;
            margin: 0 auto;
        }

        .image-upload-btn {
            display: block;
            margin: 10px auto 0;
            max-width: 200px;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .table-row-clickable:hover {
            background-color: #f8f9fa !important;
            transform: translateY(-1px);
            transition: all 0.2s ease;
        }

        .table-row-clickable {
            transition: all 0.2s ease;
        }

        .stock-bajo-alert {
            background: linear-gradient(45deg, #ff6b6b, #ee5a52);
            color: white;
            border: none;
        }
    </style>
</head>

<body>

    <div id="appStockBajo">

        <!-- NAVBAR -->
        <nav class="navbar navbar-expand-lg navbar-dark navbar-pan">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" href="#">
                    <i class="bi bi-basket"></i> Panadería Santizo
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navMenu">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item mx-2"><a class="nav-link" href="#"><i class="bi bi-bell fs-5"></i></a></li>
                        <li class="nav-item mx-2">
                            <a class="nav-link fw-semibold" href="#">
                                <i class="bi bi-person-circle me-1"></i>Usuario: Panadería Santizo
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- CONTENIDO PRINCIPAL -->
        <div class="container-fluid mt-3">
            <div class="row">

                <!-- SIDEBAR -->
                <aside class="col-12 col-md-3 col-lg-2 p-3 sidebar">
                    <div class="text-center mb-4">
                        <img src="../productos/Logo.jpeg" class="rounded-circle mb-2 Logo" alt="usuario">
                        <h6 class="fw-semibold">Panadería Santizo</h6>
                        <div class="text-muted small">Administrador</div>
                    </div>

                    <ul class="nav flex-column">
                        <li class="nav-item mb-2">
                            <a class="nav-link" href="index.php">
                                <i class="bi bi-box-seam me-2"></i>Inventario
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link" href="./proveedores.php">
                                <i class="bi bi-truck me-2"></i>Proveedores
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link active" href="#">
                                <i class="bi bi-exclamation-triangle me-2"></i>Stock Bajo
                            </a>
                        </li>
                    </ul>
                </aside>

                <!-- MAIN CONTENT -->
                <main class="col-12 col-md-9 col-lg-10 p-4">

                    <!-- HEADER -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="fw-bold mb-0">Productos con Stock Bajo</h3>
                        <div class="badge bg-danger fs-6">
                            Total: {{pagination.total}}
                        </div>
                    </div>

                    <!-- ALERTA -->
                    <div class="alert stock-bajo-alert shadow-sm mb-4">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                            <div>
                                <h5 class="alert-heading mb-1">¡Atención!</h5>
                                <p class="mb-0">Estos productos necesitan reabastecimiento urgente.</p>
                            </div>
                        </div>
                    </div>

                    <!-- TABLA -->
                    <div class="card shadow-sm border-0">
                        <div class="table-container table-responsive">
                            <table class="table align-middle table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th></th>
                                        <th>Producto</th>
                                        <th>Categoría</th>
                                        <th>Precio</th>
                                        <th class="text-end">Stock Actual</th>
                                        <th class="text-end">Límite Mínimo</th>
                                        <th class="text-end">Última acción</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="(item, index) in lista" :key="index"
                                        @click="abrirModalDetalle(item)"
                                        style="cursor: pointer;"
                                        class="table-row-clickable">
                                        <td>
                                            <img :src="'../productos/' + item.img" class="product-img">
                                        </td>
                                        <td>{{ item.nombre }}</td>
                                        <td>{{ item.categoria }}</td>
                                        <td>${{ item.precio }}</td>
                                        <td class="text-end text-danger fw-bold">{{ item.stock }}</td>
                                        <td class="text-end">{{ item.limite }}</td>
                                        <td class="text-end text-muted small">{{ item.fecha_movimiento }}</td>
                                    </tr>
                                    <tr v-if="lista.length === 0 && !loading">
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="bi bi-check-circle fs-1 d-block mb-2"></i>
                                            ¡Excelente! No hay productos con stock bajo.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-4" v-if="pagination.total_pages > 1">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center">
                                <span class="text-muted">{{ paginationInfo }}</span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <nav aria-label="Navegación de páginas">
                                <ul class="pagination justify-content-end mb-0">
                                    <!-- Botón Anterior -->
                                    <li class="page-item" :class="{ 'disabled': pagination.current_page === 1 }">
                                        <button class="page-link" @click="changePage(pagination.current_page - 1)"
                                            :disabled="pagination.current_page === 1">
                                            <i class="bi bi-chevron-left"></i>
                                        </button>
                                    </li>

                                    <!-- Primera página -->
                                    <li class="page-item" v-if="getPages()[0] > 1">
                                        <button class="page-link" @click="changePage(1)">1</button>
                                    </li>
                                    <li class="page-item disabled" v-if="getPages()[0] > 2">
                                        <span class="page-link">...</span>
                                    </li>

                                    <!-- Páginas numeradas -->
                                    <li class="page-item" v-for="page in getPages()" :key="page"
                                        :class="{ 'active': page === pagination.current_page }">
                                        <button class="page-link" @click="changePage(page)">{{ page }}</button>
                                    </li>

                                    <!-- Última página -->
                                    <li class="page-item disabled"
                                        v-if="getPages()[getPages().length - 1] < pagination.total_pages - 1">
                                        <span class="page-link">...</span>
                                    </li>
                                    <li class="page-item"
                                        v-if="getPages()[getPages().length - 1] < pagination.total_pages">
                                        <button class="page-link" @click="changePage(pagination.total_pages)">
                                            {{ pagination.total_pages }}
                                        </button>
                                    </li>

                                    <!-- Botón Siguiente -->
                                    <li class="page-item"
                                        :class="{ 'disabled': pagination.current_page === pagination.total_pages }">
                                        <button class="page-link" @click="changePage(pagination.current_page + 1)"
                                            :disabled="pagination.current_page === pagination.total_pages">
                                            <i class="bi bi-chevron-right"></i>
                                        </button>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                        <!-- Indicador de carga -->
                        <div class="row mt-3" v-if="loading">
                            <div class="col-12">
                                <div class="alert alert-info text-center">
                                    <i class="bi bi-arrow-repeat spinner"></i> Cargando productos...
                                </div>
                            </div>
                        </div>

                </main>
            </div>
        </div>

        <!-- MODAL DETALLE PRODUCTO -->
        <div class="modal fade" id="modalDetalle" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detalle del Producto - Stock Bajo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <img :src="'../productos/' + productoDetalle.img"
                                    :alt="productoDetalle.nombre"
                                    class="image-preview mb-3">
                            </div>

                            <div class="col-md-8">
                                <h4 class="text-primary">{{ productoDetalle.nombre }}</h4>
                                <p class="text-muted">{{ productoDetalle.descripcion }}</p>

                                <div class="row mt-3">
                                    <div class="col-6">
                                        <strong>Categoría:</strong><br>
                                        <span class="badge bg-secondary">{{ productoDetalle.categoria }}</span>
                                    </div>
                                    <div class="col-6">
                                        <strong>Precio:</strong><br>
                                        <span class="fw-bold text-success">${{ productoDetalle.precio }}</span>
                                    </div>
                                </div>

                                <div class="row mt-3 align-items-center">
                                    <div class="col-6">
                                        <strong>Stock actual:</strong>
                                        <input type="number"
                                            class="form-control mt-1"
                                            v-model.number="productoDetalle.stock">
                                    </div>

                                    <div class="col-6">
                                        <strong>Límite mínimo:</strong><br>
                                        {{ productoDetalle.limite }} unidades
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <strong>Último movimiento:</strong><br>
                                        <span class="text-muted">{{ productoDetalle.fecha_movimiento }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning me-auto"
                            @click="actualizarStock(productoDetalle)">
                            <i class="bi bi-arrow-repeat"></i> Actualizar Stock
                        </button>

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>

</html>