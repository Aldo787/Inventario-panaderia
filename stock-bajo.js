appStockBajo = Vue.createApp({
    data() {
        return {
            lista: [],
            loading: false,
            error: "",
            // Datos de paginación
            pagination: {
                current_page: 1,
                total: 0,
                total_pages: 0
            },
            productoDetalle: {
                id: null,
                nombre: "",
                descripcion: "",
                precio: 0,
                stock: 0,
                categoria: "",
                img: "",
                limite: 0,
                fecha_movimiento: ""
            }
        }
    },
    mounted() {
        this.cargarStockBajo();
    },

    methods: {
        async cargarStockBajo(page = 1) {
            this.loading = true;
            try {
                // Usamos la misma API pero filtramos por stock bajo
                let url = `../API/api.php?action=list&page=${page}`;
                
                const res = await fetch(url);
                if (!res.ok) {
                    throw new Error("Error/B.D", "Error de conexión base de datos");
                }
                const json = await res.json();

                if (json.success && json.data) {
                    // Filtrar productos con stock bajo localmente
                    const productosStockBajo = json.data.filter(producto => 
                        producto.stock < producto.limite
                    );
                    
                    this.lista = productosStockBajo;
                    this.pagination.total = productosStockBajo.length;
                    this.pagination.total_pages = Math.ceil(productosStockBajo.length / 25);
                    this.pagination.current_page = page;
                    console.log(this.lista)
                } else {
                    throw new Error("Error/Sistem-Internal", "Error en la respuesta");
                }
            } catch (error) {
                this.error = error.message;
                console.error('Error fetching productos con stock bajo:', error);
            } finally {
                this.loading = false;
            }
        },

        abrirModalDetalle(producto) {
            this.productoDetalle = { ...producto };
            // Mostrar el modal usando Bootstrap
            const modal = new bootstrap.Modal(document.getElementById('modalDetalle'));
            modal.show();
        },

        async actualizarStock(producto) {
            if (!confirm("¿Deseas actualizar el stock?")) return;

            try {
                const res = await fetch("../API/api.php?action=update_stock", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        id: producto.id,
                        stock: producto.stock
                    })
                });

                const json = await res.json();

                if (!json.success) {
                    alert("Error: " + json.message);
                    return;
                }

                alert("Stock actualizado correctamente");
                
                // Recargar la página para reflejar los cambios
                location.reload();

            } catch (e) {
                alert("Error de conexión");
                console.error(e);
            }
        },

        // Métodos de paginación
        async changePage(page) {
            if (page >= 1 && page <= this.pagination.total_pages) {
                this.pagination.current_page = page;
                await this.cargarStockBajo(page);
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
            const start = ((this.pagination.current_page - 1) * 25) + 1;
            const end = Math.min(this.pagination.current_page * 25, this.pagination.total);
            return `Mostrando ${start}-${end} de ${this.pagination.total} productos con stock bajo`;
        }
    }
}).mount("#appStockBajo");