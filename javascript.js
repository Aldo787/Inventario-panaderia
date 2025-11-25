app = Vue.createApp({
    data() {
        return {
            lista: [],
            loading: false,
            error: "",
            // Estadísticas globales
            estadisticas: {
                totalProductos: 0,
                stockBajo: 0,
                valorTotal: 0
            },
            // Datos de paginación
            pagination: {
                current_page: 1,
                total: 0,
                total_pages: 0
            },
            productoSeleccionado: {
                id: null,
                nombre: "",
                descripcion: "",
                precio: 0,
                stock: 0,
                categoria: "",
                img: "",
                limite: 0
            },
            nuevoProducto: {
                nombre: "",
                descripcion: "",
                precio: 0,
                stock: 0,
                categoria: "",
                img: "default.png",
                limite: 0
            },
            categorias: ["Pan", "Pastelería", "Dulces", "Galletas", "Salados"],
            erroresdatos: []
        }
    },
    mounted() {
        this.cargarDatosIniciales();
    },

    methods: {
        async cargarDatosIniciales() {
            await Promise.all([
                this.Inventario(),
                this.cargarEstadisticasGlobales()
            ]);
        },

        async Inventario(page = 1) {
            this.loading = true
            try {
                const res = await fetch(`api.php?action=list&page=${page}`)
                if (!res.ok) {
                    throw new Error("Error/B.D", "Error de conexión base de datos")
                }
                const json = await res.json()

                if (json.success && json.data) {
                    this.lista = json.data
                    this.pagination.total = json.pagination.total
                    this.pagination.total_pages = json.pagination.total_pages

                    console.log(this.pagination)
                } else {
                    throw new Error("Error/Sistem-Internal", "Error en la respuesta")
                }
            } catch (error) {
                this.error = error.message
                console.error('Error fetching productos:', error)
            } finally {
                this.loading = false;
            }
        },

        async cargarEstadisticasGlobales() {
            try {
                const res = await fetch('api.php?action=stats')
                if (!res.ok) {
                    throw new Error("Error al cargar estadísticas")
                }
                const json = await res.json()

                if (json.success && json.stats) {
                    this.estadisticas = {
                        totalProductos: json.stats.total_productos,
                        stockBajo: json.stats.stock_bajo,
                        valorTotal: json.stats.valor_total
                    }
                    console.log('Estadísticas globales:', this.estadisticas)
                } else {
                    throw new Error("Error en formato de estadísticas")
                }
            } catch (error) {
                console.error('Error cargando estadísticas:', error)
                this.estadisticas = {
                    totalProductos: 0,
                    stockBajo: 0,
                    valorTotal: 0
                }
            }
        },

        async agregarnuevoproducto() {
            // Vaciar errores antes de validar
            this.erroresdatos = [];

            const res = this.validardatos(this.nuevoProducto)
            console.log(res)
            if (!res) {
                return
            }
            try {
                const res = await fetch("api.php?action=create", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(this.nuevoProducto)
                })
                if (!res.ok) {
                    throw new Error("Error al llamar la funcion")
                }

                const json = await res.json()

                if (json.success) {
                    await this.cargarDatosIniciales()
                } else {
                    throw new Error(json.message)
                }

                const modal = bootstrap.Modal.getInstance(document.getElementById("modalNuevo"));
                modal.hide();
            } catch (error) {
                this.error = error.message
            }
        },

        abrirModalEditar(producto) {
            this.productoSeleccionado = { ...producto }
            // Vaciar errores al abrir el modal
            this.erroresdatos = [];
        },

        abrirModalNuevo() {
            this.nuevoProducto = {
                nombre: "",
                descripcion: "",
                precio: 0,
                stock: 0,
                categoria: "",
                img: "default.png",
                limite: 0
            }
            // Vaciar errores al abrir el modal
            this.erroresdatos = [];
        },

        // Método para cambiar imagen en modal editar
        cambiarImagenEditar(event) {
            const file = event.target.files[0];
            if (file) {
                // Aquí podrías subir el archivo al servidor y obtener la URL
                // Por ahora, solo actualizamos el nombre del archivo
                this.productoSeleccionado.img = file.name;

                // También podrías mostrar una vista previa local
                const reader = new FileReader();
                reader.onload = (e) => {
                    // Si quisieras mostrar vista previa sin subir al servidor
                    // document.querySelector('#modalEditar .image-preview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },

        // Método para cambiar imagen en modal nuevo
        cambiarImagenNuevo(event) {
            const file = event.target.files[0];
            if (file) {
                // Aquí podrías subir el archivo al servidor y obtener la URL
                // Por ahora, solo actualizamos el nombre del archivo
                this.nuevoProducto.img = file.name;

                // También podrías mostrar una vista previa local
                const reader = new FileReader();
                reader.onload = (e) => {
                    // Si quisieras mostrar vista previa sin subir al servidor
                    // document.querySelector('#modalNuevo .image-preview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },

        // Métodos de paginación
        async changePage(page) {
            if (page >= 1 && page <= this.pagination.total_pages) {
                this.pagination.current_page = page;
                await this.Inventario(page);
            }
        },

        // Generar array de páginas para mostrar en la interfaz
        getPages() {
            const pages = [];
            const current = this.pagination.current_page;
            const total = this.pagination.total_pages;

            let startPage = Math.max(1, current - 2);
            let endPage = Math.min(total, current + 2);

            if (current <= 3) {
                endPage = Math.min(5, total);
            }

            if (current >= total - 2) {
                startPage = Math.max(1, total - 4);
            }

            for (let i = startPage; i <= endPage; i++) {
                pages.push(i);
            }

            return pages;
        },

        validardatos(producto) {
            // Vaciar el array de errores antes de validar
            this.erroresdatos = [];

            // Nombre
            if (!producto.nombre || producto.nombre.trim() == "") {
                this.erroresdatos.push('El nombre del producto es obligatorio');
            } else if (producto.nombre.trim().length > 100) {
                this.erroresdatos.push('Máximo 100 caracteres para el nombre');
            } else if (typeof producto.nombre !== 'string') {
                this.erroresdatos.push('El nombre debe ser un texto');
            }

            //Descripción
            if (!producto.descripcion || producto.descripcion.trim() == "") {
                this.erroresdatos.push("La descripción es obligatoria");
            } else if (typeof producto.descripcion !== "string") {
                this.erroresdatos.push("La descripcion debe ser un texto");
            }

            // Precio
            const precio = parseFloat(producto.precio);
            if (isNaN(precio)) {
                this.erroresdatos.push('Ingrese un precio válido');
            } else if (precio < 0) {
                this.erroresdatos.push('El precio no puede ser negativo');
            } else if (precio > 10000) {
                this.erroresdatos.push('El precio es demasiado alto');
            }

            // Stock
            const stock = parseInt(producto.stock);
            if (isNaN(stock)) {
                this.erroresdatos.push('Ingrese una cantidad válida');
            } else if (stock < 0) {
                this.erroresdatos.push('El stock no puede ser negativo');
            } else if (stock > 100000) {
                this.erroresdatos.push('La cantidad es demasiado alta');
            } else if (!Number.isInteger(stock)) {
                this.erroresdatos.push('El stock debe ser un número entero');
            }

            // Categoría
            if (!producto.categoria || producto.categoria.trim() == "") {
                this.erroresdatos.push('La categoría es obligatoria');
            }

            // Límite mínimo
            const limite = parseInt(producto.limite);
            if (isNaN(limite)) {
                this.erroresdatos.push('Ingrese un límite mínimo válido');
            } else if (limite < 1) {
                this.erroresdatos.push('El límite mínimo es de 1');
            }

            if (this.erroresdatos.length == 0) {
                return true;
            } else {
                return false
            }
        },
        abrirInputNuevo() {
            this.$refs.fileNuevo.click();
        },

        abrirInputEditar() {
            this.$refs.fileEditar.click();
        },

        cambiarImagenNuevo(event) {
            const file = event.target.files[0];
            if (!file) return;

            // Solo usamos URL temporal, no guardamos archivo
            this.nuevoProducto.img = URL.createObjectURL(file);
        },

        cambiarImagenEditar(event) {
            const file = event.target.files[0];
            if (!file) return;

            this.productoSeleccionado.img = URL.createObjectURL(file);
        },
    },

    computed: {
        // Computed para mostrar información de paginación
        paginationInfo() {
            const start = ((this.pagination.current_page - 1) * 26)
            const end = Math.min(this.pagination.current_page * 25, this.pagination.total);
            return `Mostrando ${start}-${end} de ${this.pagination.total} productos`;
        },

        // Formatear valor total para mostrar
        valorTotalFormateado() {
            return this.estadisticas.valorTotal.toFixed(2);
        }
    }
}).mount("#app")