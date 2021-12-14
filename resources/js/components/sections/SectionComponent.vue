<template>
    <div class="row mx-0">
        <div class="col-12 table-responsive">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Código</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Estaus</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody v-if="secciones.length > 0">
                    <tr v-for="secc in secciones">
                        <th scope="row" :key="secc.id">{{ secc.id }}</th>
                        <td>{{ secc.code }}</td>
                        <td>{{ secc.name }}</td>
                        <td>{{ new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'USD' }).format(secc.price) }}</td>
                        <td>
                            <span class="badge badge-success" v-if="secc.status_id == 1">Activo</span>
                            <span class="badge badge-warning" v-else-if="secc.status_id == 2">Suspendido</span>
                        </td>
                        <td>
                            <!-- <a-button type="primary" @click="showModalEdit(d.id)">Editar</a-button> -->
                            <a :href="'section/edit/' + secc.id" class="btn btn-primary">Editar</a>
                            <a-tooltip placement="top" title="Suspender">
                                <a-button type="default" v-if="secc.status_id == 1" @click="showConfirmActive(secc.id, 2)"><a-icon type="stop" /></a-button>
                            </a-tooltip>
                            <a-tooltip placement="top" title="Activar">
                                <a-button type="default" v-if="secc.status_id == 2" @click="showConfirmActive(secc.id, 1)"><a-icon type="check-circle" /></a-button>
                            </a-tooltip>
                            <a-button type="danger" @click="showDeleteConfirm(secc.id)">Eliminar</a-button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-12 text-center">
            <a-empty v-if="secciones.length == 0">
                <span slot="description"> No hay datos </span>
            </a-empty>
        </div>
    </div>
</template>

<script>
let dollarUSLocale = new Intl.NumberFormat('en-US', {
    style: "currency",
    currency: "USD",
});

export default {
    props: {
        secciones: Array,
    },
    data() {
        return {
            
        }
    },
    mounted() {
        
    },
    methods: {
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
                    axios.put('/section/change-status', {
                        id: id,
                        status: status,
                    })
                    .then(function (response) {
                        console.log(response);
                        me.$message.success('Se actualizo correctamente.');
                        window.location.reload();
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
                    axios.put('/section/change-status', {
                        id: id,
                        status: 3,
                    })
                    .then(function (response) {
                        console.log(response);
                        me.$message.success('Se elimino correctamente.');
                        window.location.reload();
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

<style>

</style>