<template>
    <div class="row d-flex justify-content-center">
        <div class="col-md-8">
            <fieldset>
                <a-spin tip="Creando Articulo..." :spinning="loading">
                    <legend>Artículo</legend>
                    <form @submit.prevent="submit">
                        <div class="form-group">
                            <label for="code">Código</label>
                            <input type="text" class="form-control" id="code" name="code" v-model="fields.code" >
                            <div v-if="errors && errors.code" class="text-danger">{{ errors.code[0] }}</div>
                        </div>
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" v-model="fields.name" >
                            <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                        </div>
                        <div class="form-group">
                            <label for="price">Precio</label>
                            <input type="number" class="form-control" id="price" name="price" step="any" v-model="fields.price" >
                            <div v-if="errors && errors.price" class="text-danger">{{ errors.code[0] }}</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Crear</button>
                    </form>
                </a-spin>
            </fieldset>
            <div class="my-3">
                <a-alert
                    v-if="success"
                    message="Operación Exitosa"
                    description="Se registro artículo exitosamente."
                    type="success"
                    show-icon
                    closable
                    :after-close="handleClose"
                />
            </div>
        </div>
    </div>
</template>

<style scoped>
.spin-content {
    text-align: center;
    border: 1px solid #91d5ff;
    background-color: #e6f7ff;
    padding: 30px 50px;
    margin: 20px 0;
}
</style>
<script>
export default {
    data() {
        return {
            fields: {},
            errors: {},
            success: false,
            loading:false,
            visible: true,
        }
    },
    mounted() {
        
    },
    methods: {
        submit() {
            if (!this.loading) {
                this.loading = true;
                this.success = false;
                this.errors = {};
                axios.post('/section/store', this.fields).then(response => {
                    console.log(response);
                    this.fields = {}; //Clear input fields.
                    this.loading = false;
                    this.success = true;
                }).catch(error => {
                    console.log(error);
                    this.loading = false;
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                    }
                });
            }
        },
        handleClose() {
            this.visible = false;
        },
    },
}
</script>