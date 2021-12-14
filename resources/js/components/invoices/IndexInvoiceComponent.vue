<template>
    <div class="row mx-0">
        <div class="col-12 table-responsive">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Código Factura</th>
                        <th scope="col">Nomre</th>
                        <th scope="col">Razón Social</th>
                        <th scope="col">Código Pedido</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Estatus Factura</th>
                        <th scope="col">Comprobante</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody v-if="facturas.length > 0">
                    <tr v-for="f in facturas">
                        <th scope="row" :key="f.id">{{ f.id }}</th>
                        <td>{{ f.code_invoice }}</td>
                        <td>{{ f.name }}</td>
                        <td>{{ f.company_name }}</td>
                        <td>{{ f.code_order }}</td>
                        <td>{{ f.date }}</td>
                        <td>
                            <span class="badge badge-success" v-if="f.status_id == 1">Activo</span>
                            <span class="badge badge-danger" v-else-if="f.status_id == 4">Cancelado</span>
                        </td>
                        <td>
                            <a v-if="f.file != null" :href="'/invoice/donwload-voucher/' + f.file" download class="btn btn-info">
                                <a-icon type="download" />
                            </a>
                        </td>
                        <td>
                            <a :href="'/invoice/edit/' + f.id" class="btn btn-primary">Editar</a>
                            <a-tooltip placement="top" title="Cancelar">
                                <a-button type="default" v-if="f.status_id == 1" @click="showConfirmActive(f.id, 4)"><a-icon type="stop" /></a-button>
                            </a-tooltip>
                            <a-button type="danger" @click="showDeleteConfirm(f.id)">Eliminar</a-button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-12 text-center">
            <a-empty v-if="facturas.length == 0">
                <span slot="description"> No hay datos </span>
            </a-empty>
        </div>
    </div>
</template>

<script>
export default {
    props: {

    },
    data() {
        return {
            facturas: [],
        }
    },
    mounted() {
        this.getAllInvoices();
    },
    methods: {
        getAllInvoices() {
            let me = this;
            axios.get('/invoice/get-invoices')
            .then(res => {
                console.log(res);
                me.facturas = res.data.invoices;
            })
            .catch(error => {
                console.log(error);
            });
        },
        showConfirmActive(id, status) {
            let me = this;
            this.$confirm({
                title: 'Está seguro de realizar la modificación?',
                content: 'Some descriptions',
                okText: 'Si',
                okType: 'primary',
                cancelText: 'No',
                onOk() {
                    console.log('OK');
                    axios.put('/invoice/change-status', {
                        id: id,
                        status: status,
                    })
                    .then(function (response) {
                        console.log(response);
                        me.$message.success('Se actualizo correctamente.');
                        me.getAllInvoices();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                },
                onCancel() {
                    console.log('Cancel');
                },
            });
        },
        showDeleteConfirm(id) {
            let me = this;
            this.$confirm({
                title: 'Está seguro de eliminar el registro?',
                content: 'Some descriptions',
                okText: 'Si',
                okType: 'danger',
                cancelText: 'No',
                onOk() {
                    console.log('OK');
                    axios.put('/invoice/change-status', {
                        id: id,
                        status: 3,
                    })
                    .then(function (response) {
                        console.log(response);
                        me.$message.success('Se elimino correctamente.');
                        me.getAllInvoices();
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                },
                onCancel() {
                    console.log('Cancel');
                },
            });
        },
    },
}
</script>