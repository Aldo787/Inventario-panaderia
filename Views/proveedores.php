<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedores - Panadería Santizo</title>

    <!-- Bootstrap local -->
    <link rel="stylesheet" href="../../Bootstrap.css">
    <script src="../../Bootstrap.js"></script>

    <!-- Iconos -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Vue -->
    <script src="../../vue3.js"></script>
    <script defer src="../proveedores.js"></script>

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

        .badge-activo {
            background-color: #28a745;
        }

        .badge-inactivo {
            background-color: #dc3545;
        }
    </style>
</head>

<body>
    <div id="appProveedores">
        <!-- NAVBAR -->
        <nav class="navbar navbar-expand-lg navbar-dark navbar-pan">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold" href="#">
                    <i class="bi bi-truck"></i> Panadería Santizo - Proveedores
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
                            <a class="nav-link active" href="#">
                                <i class="bi bi-truck me-2"></i>Proveedores
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a class="nav-link" href="./stock-bajo.php">
                                <i class="bi bi-clock-history me-2"></i>Productos - Stock Bajo
                            </a>
                        </li>
                    </ul>
                </aside>

                <!-- MAIN CONTENT -->
                <main class="col-12 col-md-9 col-lg-10 p-4">
                    <!-- HEADER -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="fw-bold mb-0">Gestión de Proveedores</h3>
                        <div>
                            <button class="btn btn-primary btn-modern" data-bs-toggle="modal"
                                data-bs-target="#modalNuevoProveedor" @click="abrirModalNuevo()">
                                <i class="bi bi-plus-lg"></i> Nuevo Proveedor
                            </button>
                        </div>
                    </div>

                    <!-- STATS -->
                    <div class="row g-3 mb-4">
                        <div class="col-12 col-md-6">
                            <div class="card card-stats shadow-sm text-center p-3">
                                <div class="text-primary mb-2"><i class="bi bi-building fs-1"></i></div>
                                <h5>Total de Proveedores</h5>
                                <h3 class="fw-bold">{{totalProveedores}}</h3>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card card-stats shadow-sm text-center p-3">
                                <div class="text-success mb-2"><i class="bi bi-check-circle fs-1"></i></div>
                                <h5>Proveedores Activos</h5>
                                <h3 class="fw-bold">{{proveedoresActivos}}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- BUSCADOR -->
                    <div class="row mb-3">
                        <div class="col-md-6 mb-2">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Buscar proveedor..." v-model="searchQuery">
                                <button class="btn btn-primary" type="button" @click="buscarProveedores">
                                    <i class="bi bi-search"></i> Buscar
                                </button>
                                <button class="btn btn-outline-secondary" type="button" @click="limpiarBusqueda" v-if="searchQuery">
                                    <i class="bi bi-x-circle"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- TABLA -->
                    <div class="card shadow-sm border-0">
                        <div class="table-container table-responsive">
                            <table class="table align-middle table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Proveedor</th>
                                        <th>Contacto</th>
                                        <th>Teléfono</th>
                                        <th>Email</th>
                                        <th>Dirección</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="(item, index) in lista" :key="index">
                                        <td class="fw-semibold">{{ item.nombre }}</td>
                                        <td>{{ item.contacto }}</td>
                                        <td>{{ item.telefono }}</td>
                                        <td>{{ item.email || 'N/A' }}</td>
                                        <td>{{ item.direccion }}</td>
                                        <td class="text-center">
                                            <span class="badge" :class="item.estado === 'Activo' ? 'badge-activo' : 'badge-inactivo'">
                                                {{ item.estado }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditarProveedor"
                                                @click="abrirModalEditar(item)">
                                                <i class="bi bi-pencil"></i> Editar
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger"
                                                @click="confirmarEliminar(item.id)">
                                                <i class="bi bi-trash"></i> Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                    <tr v-if="lista.length === 0 && !loading">
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                            No se encontraron proveedores
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Indicador de carga -->
                    <div class="row mt-3" v-if="loading">
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <i class="bi bi-arrow-repeat spinner"></i> Cargando proveedores...
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <!-- MODAL EDITAR PROVEEDOR -->
        <div class="modal fade" id="modalEditarProveedor" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Proveedor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form @submit.prevent="actualizarProveedor">
                        <div class="modal-body">
                            <!-- Sección de errores -->
                            <div class="alert alert-danger" v-if="erroresdatos.length > 0">
                                {{ erroresdatos[0] }}
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nombre del Proveedor</label>
                                    <input type="text" class="form-control" v-model="proveedorSeleccionado.nombre"
                                        placeholder="Ej. Distribuidora ABC" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Persona de Contacto</label>
                                    <input type="text" class="form-control" v-model="proveedorSeleccionado.contacto"
                                        placeholder="Ej. Juan Pérez" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" v-model="proveedorSeleccionado.telefono"
                                        placeholder="Ej. 12345678" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" v-model="proveedorSeleccionado.email"
                                        placeholder="Ej. contacto@proveedor.com">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Dirección</label>
                                    <textarea class="form-control" v-model="proveedorSeleccionado.direccion"
                                        placeholder="Dirección completa..." rows="2" required></textarea>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Estado</label>
                                    <select class="form-select" v-model="proveedorSeleccionado.estado" required>
                                        <option value="Activo">Activo</option>
                                        <option value="Inactivo">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- MODAL NUEVO PROVEEDOR -->
        <div class="modal fade" id="modalNuevoProveedor" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Nuevo Proveedor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Sección de errores -->
                        <div class="alert alert-danger" v-if="erroresdatos.length > 0">
                            {{ erroresdatos[0] }}
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nombre del Proveedor</label>
                                <input type="text" class="form-control" v-model="nuevoProveedor.nombre"
                                    placeholder="Ej. Distribuidora ABC" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Persona de Contacto</label>
                                <input type="text" class="form-control" v-model="nuevoProveedor.contacto"
                                    placeholder="Ej. Juan Pérez" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Teléfono</label>
                                <input type="text" class="form-control" v-model="nuevoProveedor.telefono"
                                    placeholder="Ej. 12345678" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" v-model="nuevoProveedor.email"
                                    placeholder="Ej. contacto@proveedor.com">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Dirección</label>
                                <textarea class="form-control" v-model="nuevoProveedor.direccion"
                                    placeholder="Dirección completa..." rows="2" required></textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Estado</label>
                                <select class="form-select" v-model="nuevoProveedor.estado" required>
                                    <option value="Activo">Activo</option>
                                    <option value="Inactivo">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button class="btn btn-success" @click="agregarNuevoProveedor()">Crear Proveedor</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>