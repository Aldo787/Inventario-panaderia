app = Vue.createApp({
    data() {
        return {
            lista: [],
            loadin: false,
            error: "",
            stockbajo:[],
            Totalstock:0,
        }
    },
    mounted() {
        this.Inventario()
    },

    methods: {
        async Inventario() {
            this.loadin = true
            try {
                const res = await fetch("api.php?action=list")
                if (!res.ok) {
                    throw new Error("Error/B.D", "Error de conexion base de datos")
                }
                const json = await res.json()

                if (json.success && json.data) {
                    this.lista = json.data
                    console.log(this.lista)
                    this.Estadisticas(this.lista)
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
        async Estadisticas(lista){
          this.stockbajo = lista.filter(producto => producto.stock <= producto.limite)

          this.Totalstock = lista.reduce((acumulador,producto) => {
            return acumulador + (producto.stock * producto.precio);
          },0)
        }
    },
}).mount("#app")