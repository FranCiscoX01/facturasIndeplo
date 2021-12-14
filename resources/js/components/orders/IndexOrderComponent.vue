<template>
    <div class="row mx-0">
        <div class="col-12 table-responsive">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Razón Social</th>
                        <th scope="col">Código</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Estatus Pedido</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody v-if="pedidos.length > 0">
                    <tr v-for="p in pedidos">
                        <th scope="row" :key="p.id">{{ p.id }}</th>
                        <td>{{ p.name }}</td>
                        <td>{{ p.company_name }}</td>
                        <td>{{ p.code }}</td>
                        <td>{{ p.date }}</td>
                        <td>
                            <span class="badge badge-success" v-if="p.status_id == 1">Activo</span>
                            <span class="badge badge-warning" v-else-if="p.status_id == 2">Suspendido</span>
                        </td>
                        <td>
                            <a :href="'/order/edit/' + p.id" class="btn btn-primary">Editar</a>
                            <a-tooltip placement="top" title="Suspender">
                                <a-button type="default" v-if="p.status_id == 1" @click="showConfirmActive(p.id, 2)"><a-icon type="stop" /></a-button>
                            </a-tooltip>
                            <a-tooltip placement="top" title="Activar">
                                <a-button type="default" v-if="p.status_id == 2" @click="showConfirmActive(p.id, 1)"><a-icon type="check-circle" /></a-button>
                            </a-tooltip>
                            <a-button type="danger" @click="showDeleteConfirm(p.id)">Eliminar</a-button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-12 text-center">
            <a-empty v-if="pedidos.length == 0">
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
            pedidos: [],
        }
    },
    mounted() {
        this.getAllOrders();
    },
    methods: {
        getAllOrders() {
            let me = this;
            axios.get('/order/show')
            .then(res => {
                console.log(res);
                me.pedidos = res.data.order;
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
                    axios.put('/order/change-status', {
                        id: id,
                        status: status,
                    })
                    .then(function (response) {
                        console.log(response);
                        me.$message.success('Se actualizo correctamente.');
                        me.getAllOrders();
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
                    axios.put('/order/change-status', {
                        id: id,
                        status: 3,
                        })
                    .then(function (response) {
                        console.log(response);
                        me.$message.success('Se elimino correctamente.');
                        me.getAllOrders();
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