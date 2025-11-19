app = Vue.createApp({
    data() {
        return {
            lista: [],
            loadin: false,
            error: ""
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
    },
}).mount("#app")