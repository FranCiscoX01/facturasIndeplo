<template>
    <div class="row mx-0 d-flex justify-content-center">
        <div class="col-md-8">
            <fieldset>
                <a-spin tip="Cargando..." :spinning="loading">
                    <legend>Elaborar Factura:</legend>
                    <a-form-model ref="ruleForm" :rules="rules" :model="invoice" @submit="handleSubmit">
                        <a-form-model-item class="form-group" ref="code" prop="code" >
                            <label for="code">Código</label>
                            <input type="text" class="form-control" id="code" v-model="invoice.code" >
                        </a-form-model-item>
                        <a-form-model-item class="form-group" prop="order_id">
                            <label for="order">Pedido</label>
                            <a-select
                                show-search
                                placeholder="Seleccione un pedido"
                                option-filter-prop="children"
                                style="width: 100%"
                                :filter-option="filterOptionOrder"
                                @focus="handleFocusOrder"
                                @blur="handleBlurOrder"
                                allowClear
                                :required="true"
                                v-model="invoice.order_id"
                            >
                                <a-select-option v-for="o in orders" :key="o.order_id" :value="o.order_id" >
                                    {{ o.name }} - {{ o.code }}
                                </a-select-option>
                            </a-select>
                        </a-form-model-item>
                        <div class="form-group">
                            <label for="file">Comprobante de Factura</label>
                            <a-upload-dragger
                                accept="application/pdf"
                                action="/invoice/upload"
                                :fileList="fileList"
                                :data =  "setDataUploadPhoto"
                                :headers = "headers"
                                @change="handleChangeFile"
                                :remove="handleRemove"
                            >
                                <p class="ant-upload-drag-icon">
                                <a-icon type="inbox" />
                                </p>
                                <p class="ant-upload-text">
                                Click or drag file to this area to upload
                                </p>
                                <p class="ant-upload-hint">
                                Support for a single or bulk upload. Strictly prohibit from uploading company data or other
                                band files
                                </p>
                            </a-upload-dragger>
                        </div>
                        <div class="form-group text-right">
                            <a-button type="primary" html-type="submit">
                                Guardar
                            </a-button>
                        </div>
                    </a-form-model>
                </a-spin>
            </fieldset>
        </div>
    </div>
</template>

<script>
export default {
    props: ['invoiceId'],
    data() {
        return {
            invoice: {},
            orders: [],
            formLayout: 'horizontal',
            form: this.$form.createForm(this, { name: 'coordinated' }),
            fileList:[],
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            fileName: "",
            loading: false,
            rules: {
                code: [{ required: true, message: 'Por favor ingrese código', trigger: 'blur' }],
                order_id: [{ required: true, message: 'Por favor seleccione un pedido', trigger: 'change' }],
            }
        }
    },
    mounted() {
        this.getAllOrders();
        this.getInvoiceById(this.invoiceId);
    },
    methods: {
        getAllOrders() {
            this.loading = true;
            let me = this;
            axios.get('/invoice/get-orders')
            .then(res => {
                console.log(res);
                me.orders = res.data.orders;
            })
            .catch(err => {
                console.log(err);
            });
        },
        getInvoiceById(id) {
            let me = this;
            axios.get('/invoice/get-invoice/' + id)
            .then(res => {
                console.log(res);
                me.invoice = res.data.res
                me.loading = false;
            })
            .catch(err => {
                console.log(err);
            });
        },
        handleSubmit(e) {
            e.preventDefault();
            let me = this;
            this.$refs.ruleForm.validate(valid => {
                if (valid) {
                    axios.post('/invoice/update', {
                        data: me.invoice,
                        file: me.fileName
                    })
                    .then(function(response) {
                        console.log(response);
                        if(response.status == 200) {
                            me.fileList = [];
                            me.$notification['success']({
                                message: 'Creación Exitosa!',
                                description: 'Se ha creado el registro exitosamente!',
                            });
                            me.getAllOrders();
                            me.getInvoiceById(me.invoiceId);
                        }
                    })
                    .catch(function(error) {
                        console.log(error);
                    });
                } else {
                    console.log('error submit!!');
                    me.$notification['warning']({
                        message: 'Algo salio mal',
                        description: 'Verifique ingresar todos los datos solicitados e intentelo de nuevo.',
                    });
                    return false;
                }
                // console.log(this.invoice);
                // console.log(this.fileName);
            });
        },
        // Order
        handleChangeOrder(value) {
            console.log(`selected ${value}`);
            this.form.setFieldsValue({
                order_id: value,
            });
        },
        removeOrder(value){
            console.log(`deselected ${value}`);
        },
        handleBlurOrder() {
            console.log('blur');
        },
        handleFocusOrder() {
            console.log('focus');
        },
        filterOptionOrder(input, option) {
            return (
                option.componentOptions.children[0].text.toLowerCase().indexOf(input.toLowerCase()) >= 0
            );
        },
        handleChangeFile(info) {
            let fileList = [...info.fileList];

            // 1. Limit the number of uploaded files
            //    Only to show two recent uploaded files, and old ones will be replaced by the new
            fileList = fileList.slice(-1);

            // 2. read from response and show file link
            fileList = fileList.map(file => {
                if (file.response) {
                // Component will show file.url as link
                file.url = file.response.url;
                }
                return file;
            });

            this.fileList = fileList;


            const status = info.file.status;
            if (status !== 'uploading') {
                console.log(info.file, info.fileList);
                this.fileName = info.file.response;
            }
            if (status === 'done') {
                this.$message.success(`${info.file.name} file uploaded successfully.`);
            } else if (status === 'error') {
                this.$message.error(`${info.file.name} file upload failed.`);
            }
        },
        handleRemove(file){
            let me = this;
            axios.post('/invoice/deleteVoucher',{
                uid : file.uid,
            }).
            then(function(response){
                //$("#"+file.uid).remove();
                me.fileName = "";
            }).catch(function(error){
                //console.log(error);
            });
        },
        setDataUploadPhoto(file){ // Los datos que se veran en el $request['']
            return { dataFile: file.uid, size: file.size, folder:'invoice', tmp:1};
        },
    },
}
</script>