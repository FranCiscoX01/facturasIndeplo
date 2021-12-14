<template>
    <div class="row d-flex justify-content-center">
        <div class="col-md-8">
            <fieldset>
                <a-spin tip="Creando Cliente..." :spinning="loading">
                    <legend>Cliente:</legend>
                    <a-form :form="form" ref="customerForm" :label-col="{ span: 5 }" :wrapper-col="{ span: 12 }" @submit="handleSubmit">
                        <a-form-item label="Nombre">
                            <a-input v-decorator="['name', { rules: [{ required: true, message: 'Por favor complete su nombre' }] }]" />
                        </a-form-item>
                        <a-form-item label="Razón Social">
                            <a-input v-decorator="['company_name', { rules: [{ required: true, message: 'Por favor complete su razón social' }] }]" />
                        </a-form-item>
                        <a-form-item :wrapper-col="{ span: 12, offset: 5 }">
                            <a-button type="primary" html-type="submit">
                                Crear cliente
                            </a-button>
                        </a-form-item>
                    </a-form>
                </a-spin>
            </fieldset>
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
                formLayout: 'horizontal',
                form: this.$form.createForm(this, { name: 'costumer' }),
                loading:false
            };
        },
        mounted() {
            console.log('Component mounted.');
        },
        methods: {
            handleSubmit(e) {
                e.preventDefault();
                this.form.validateFields((err, values) => {
                    if (!err) {
                        console.log('Received values of form: ', values);
                        let me = this;
                        this.loading = true;
                        axios.post('/costumer/store', {
                            name: values.name,
                            company_name: values.company_name
                        })
                        .then(function(response) {
                            console.log(response);
                            if(response.data) {
                                me.form.resetFields();
                                me.loading = false
                                me.$notification['success']({
                                    message: 'Creación Exitosa!',
                                    description: 'Se ha creado el registro exitosamente!',
                                });
                            } else {
                                me.form.resetFields();
                                me.loading = false
                                me.$notification['warning']({
                                    message: 'Algo salio mal',
                                    description: 'Verifique ingresar todos los datos solicitados e intentelo de nuevo.',
                                });
                            }
                        })
                        .catch(function(error) {
                            console.log(error);
                        });
                    }
                });
            },
        },
    }
</script>
