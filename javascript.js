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
                per_page: 25, // Fijo en 25 productos por página
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
                img: "",
                limite: 0
            },
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
                    this.pagination = json.pagination
                    console.log('Productos cargados:', this.lista)
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

        abrirModalEditar(producto) {
            this.productoSeleccionado = { ...producto }
        },

        abrirModalNuevo() {
            this.nuevoProducto = {
                nombre: "",
                descripcion: "",
                precio: 0,
                stock: 0,
                categoria: "",
                img: "",
                limite: 0
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
        }
    },

    computed: {
        // Computed para mostrar información de paginación
        paginationInfo() {
            const start = ((this.pagination.current_page - 1) * this.pagination.per_page) + 1;
            const end = Math.min(this.pagination.current_page * this.pagination.per_page, this.pagination.total);
            return `Mostrando ${start}-${end} de ${this.pagination.total} productos`;
        },

        // Formatear valor total para mostrar
        valorTotalFormateado() {
            return this.estadisticas.valorTotal.toFixed(2);
        }
    }
}).mount("#app")