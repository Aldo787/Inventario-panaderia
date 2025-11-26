appProveedores = Vue.createApp({
    data() {
        return {
            lista: [],
            loading: false,
            error: "",
            proveedorSeleccionado: {
                id: null,
                nombre: "",
                contacto: "",
                telefono: "",
                email: "",
                direccion: "",
                estado: "Activo"
            },
            nuevoProveedor: {
                nombre: "",
                contacto: "",
                telefono: "",
                email: "",
                direccion: "",
                estado: "Activo"
            },
            searchQuery: "",
            erroresdatos: []
        }
    },

    mounted() {
        this.cargarProveedores();
    },

    methods: {

        async cargarProveedores() {
            this.loading = true;
            try {
                let url = `../API/proveedores_api.php?action=list`;

                if (this.searchQuery) {
                    url += `&search=${encodeURIComponent(this.searchQuery.trim())}`;
                }

                const res = await fetch(url);
                if (!res.ok) throw new Error("Error de conexión con la base de datos");

                const json = await res.json();

                if (json.success && json.data) {
                    this.lista = json.data;
                } else {
                    throw new Error("Error en la respuesta del servidor");
                }

            } catch (error) {
                this.error = error.message;
            } finally {
                this.loading = false;
            }
        },

        async agregarNuevoProveedor() {
            this.erroresdatos = [];

            const valido = this.validarDatos(this.nuevoProveedor);
            if (!valido) return;

            try {
                const resp = await fetch("../API/proveedores_api.php?action=create", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(this.nuevoProveedor)
                });

                if (!resp.ok) throw new Error("Error al crear el proveedor");

                const json = await resp.json();

                if (json.success) {
                    await this.cargarProveedores();

                    const modal = bootstrap.Modal.getInstance(
                        document.getElementById("modalNuevoProveedor")
                    );
                    modal.hide();

                    this.nuevoProveedor = {
                        nombre: "",
                        contacto: "",
                        telefono: "",
                        email: "",
                        direccion: "",
                        estado: "Activo"
                    };
                } else {
                    throw new Error(json.message || "Error al crear proveedor");
                }

            } catch (error) {
                this.error = error.message;
            }
        },

        async actualizarProveedor() {
            this.erroresdatos = [];

            const valido = this.validarDatos(this.proveedorSeleccionado);
            if (!valido) return;

            try {
                const resp = await fetch("../API/proveedores_api.php?action=update", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(this.proveedorSeleccionado)
                });

                if (!resp.ok) throw new Error("Error al actualizar el proveedor");

                const json = await resp.json();

                if (json.success) {
                    await this.cargarProveedores();
                    const modal = bootstrap.Modal.getInstance(
                        document.getElementById("modalEditarProveedor")
                    );
                    modal.hide();
                } else {
                    throw new Error(json.message || "Error al actualizar proveedor");
                }

            } catch (error) {
                this.error = error.message;
            }
        },

        abrirModalEditar(proveedor) {
            this.proveedorSeleccionado = { ...proveedor };
            this.erroresdatos = [];
        },

        abrirModalNuevo() {
            this.nuevoProveedor = {
                nombre: "",
                contacto: "",
                telefono: "",
                email: "",
                direccion: "",
                estado: "Activo"
            };
            this.erroresdatos = [];
        },

        buscarProveedores() {
            this.cargarProveedores();
        },

        limpiarBusqueda() {
            this.searchQuery = "";
            this.cargarProveedores();
        },

        // 🔥 Validación corregida completamente
        validarDatos(proveedor) {
            this.erroresdatos = [];

            // Nombre
            if (!proveedor.nombre?.trim()) {
                this.erroresdatos.push("El nombre del proveedor es obligatorio");
            } else if (proveedor.nombre.trim().length > 100) {
                this.erroresdatos.push("Máximo 100 caracteres para el nombre");
            }

            // Contacto
            if (!proveedor.contacto?.trim()) {
                this.erroresdatos.push("El nombre del contacto es obligatorio");
            }

            // Teléfono
            if (!proveedor.telefono) {
                this.erroresdatos.push("El teléfono es obligatorio");
            } else {
                const tel = String(proveedor.telefono).replace(/\s/g, '');
                if (!/^\d{8,15}$/.test(tel)) {
                    this.erroresdatos.push("Ingrese un teléfono válido (8-15 dígitos)");
                }
            }

            // Email (solo si viene)
            if (proveedor.email?.trim()) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(proveedor.email.trim())) {
                    this.erroresdatos.push("Ingrese un email válido");
                }
            }

            // Dirección
            if (!proveedor.direccion?.trim()) {
                this.erroresdatos.push("La dirección es obligatoria");
            }

            return this.erroresdatos.length === 0;
        },
        async confirmarEliminar(id) {
            if (!confirm("¿Estás seguro de eliminar este proveedor?")) {
                return;
            }

            try {
                const resp = await fetch("../API/proveedores_api.php?action=delete", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ id })
                });

                if (!resp.ok) throw new Error("Error al eliminar el proveedor");

                const json = await resp.json();

                if (json.success) {
                    await this.cargarProveedores();
                } else {
                    alert(json.message || "No se pudo eliminar el proveedor");
                }

            } catch (error) {
                alert("Error: " + error.message);
            }
        },
        
    },

    computed: {
        totalProveedores() {
            return this.lista.length;
        },
        proveedoresActivos() {
            return this.lista.filter(p => p.estado === "Activo").length;
        }
    }
}).mount("#appProveedores");
