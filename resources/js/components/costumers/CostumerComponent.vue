<template>
    <div class="row mx-0">
        <div class="col-12 table-responsive">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Razón Social</th>
                        <th scope="col">Estatus</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody v-if="data.length > 0">
                    <tr v-for="d in data">
                        <th scope="row" :key="d.id">{{ d.id }}</th>
                        <td>{{ d.name }}</td>
                        <td>{{ d.company_name }}</td>
                        <td>
                            <span class="badge badge-success" v-if="d.status_id == 1">Activo</span>
                            <span class="badge badge-warning" v-else-if="d.status_id == 2">Suspendido</span>
                        </td>
                        <td>
                            <a-button type="primary" @click="showModalEdit(d.id)">Editar</a-button>
                            <a-tooltip placement="top" title="Suspender">
                                <a-button type="default" v-if="d.status_id == 1" @click="showConfirmActive(d.id, 2)"><a-icon type="stop" /></a-button>
                            </a-tooltip>
                            <a-tooltip placement="top" title="Activar">
                                <a-button type="default" v-if="d.status_id == 2" @click="showConfirmActive(d.id, 1)"><a-icon type="check-circle" /></a-button>
                            </a-tooltip>
                            <a-button type="danger" @click="showDeleteConfirm(d.id)">Eliminar</a-button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-12 text-center">
            <a-empty v-if="data.length == 0">
                <span slot="description"> No hay datos </span>
            </a-empty>
        </div>
        <div class="col-12">
            <a-modal v-model="visible" title="Editar Información" @ok="handleOkEdit" okText="Actualizar">
                <p>
                    <span>Nombre</span>
                    <a-input v-model="edit.name" :value="edit.name" />
                </p>
                <p>
                    <span>Razón Social</span>
                    <a-input v-model="edit.company_name" :value="edit.company_name" />
                </p>
            </a-modal>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                data: [],
                loading: false,
                visible: false,
                edit: {
                    id: 0,
                    name: "",
                    company_name: "",
                }
            };
        },
        mounted() {
            console.log('Component mounted.');
            this.getAllCostumers();
        },
        methods: {
            getAllCostumers() {
                let me = this;
                axios.get('/costumer/show')
                .then(function (response) {
                    console.log(response);
                    me.data = response.data
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            showModalEdit(id) {
                this.visible = true;
                this.getCostumerByID(id);
            },
            handleOkEdit(e) {
                console.log(e);
                this.visible = false;

                let me = this;
                axios.put('/costumer/update', {
                    id: me.edit.id,
                    name: me.edit.name,
                    company_name: me.edit.company_name
                })
                .then(function (response) {
                    console.log(response);
                    me.$message.success('Se actualizo correctamente.');
                    me.getAllCostumers();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getCostumerByID(id) {
                let me = this;
                axios.get('/costumer/edit/' + id)
                .then(function (response) {
                    console.log(response);
                    me.edit.id = response.data.id;
                    me.edit.name = response.data.name;
                    me.edit.company_name = response.data.company_name;
                })
                .catch(function (error) {
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
                        axios.put('/costumer/change-status', {
                            id: id,
                            status: status,
                        })
                        .then(function (response) {
                            console.log(response);
                            me.$message.success('Se actualizo correctamente.');
                            me.getAllCostumers();
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
                        axios.put('/costumer/change-status', {
                            id: id,
                            status: 3,
                        })
                        .then(function (response) {
                            console.log(response);
                            me.$message.success('Se elimino correctamente.');
                            me.getAllCostumers();
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
