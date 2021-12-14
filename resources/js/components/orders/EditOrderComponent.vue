<template>
    <div class="row mx-0 d-flex justify-content-center">
        <div class="col-md-8">
            <fieldset>
                <a-spin tip="Cargando Pedido..." :spinning="loading">
                    <legend>Editar Pedido:</legend>
                    <form @submit.prevent="handleSubmit">
                        <div class="form-group">
                            <label for="costumer">Cliente</label>
                            <a-select
                                show-search
                                placeholder="Seleccione un cliente"
                                option-filter-prop="children"
                                style="width: 100%"
                                :filter-option="filterOptionCostumer"
                                @focus="handleFocusCostumer"
                                @blur="handleBlurCostumer"
                                @change="handleChangeCostumer"
                                allowClear
                                :required="true"
                                v-model="order.costumer_id"
                            >
                                <a-select-option v-for="c in costumers" :key="c.id" :value="c.id" >
                                    {{ c.name }} - {{ c.company_name }}
                                </a-select-option>
                            </a-select>
                        </div>
                        <div class="form-group">
                            <label for="costumer">Código</label>
                            <a-input v-model="order.code" />
                        </div>
                        <fieldset class="mt-4">
                            <legend>Articulos</legend>
                            
                            <div class="" v-for="oi in order_items">
                                <div class="form-group">
                                    <label for="section">Articulo</label>
                                    <a-select
                                        show-search
                                        placeholder="Seleccione un articulo"
                                        option-filter-prop="children"
                                        style="width: 100%"
                                        :filter-option="filterOptionSection"
                                        @focus="handleFocusSection"
                                        @blur="handleBlurSection"
                                        @change="handleChangeSection($event, oi)"
                                        allowClear
                                        v-model="oi.section_id"
                                    >
                                        <a-select-option v-for="s in sections" :key="s.id">
                                            {{ s.code }} - {{ s.name }}
                                        </a-select-option>
                                    </a-select>
                                </div>
                                <div class="form-group form-row">
                                    <div class="col">
                                        <label for="quantity">Cantidad</label>
                                        <a-input-number id="quantity" style="width: 100%" :min="1" v-model="oi.quantity" @change="onChangeQuantity" 
                                        />
                                    </div>
                                    <div class="col">
                                        <label for="costumer">Precio</label>
                                        <br>
                                        <h5 style="margin-bottom: 0 !important; line-height: inherit !important;">{{ new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'USD' }).format(oi.price * oi.quantity) }}</h5>
                                    </div>
                                    <div class="col" v-if="order_items.length > 1">
                                        <a-button 
                                            type="danger" 
                                            icon="delete" 
                                            size="large" 
                                            @click="() => removeOrderItem(oi.order_item_id)"
                                        />
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <div class="form-group text-right">
                            <a-button type="primary" html-type="submit" >
                                Guardar Pedido
                            </a-button>
                        </div>
                    </form>
                </a-spin>
            </fieldset>
        </div>
    </div>
</template>

<script>
export default {
    props: ["orderId"],
    data() {
        return {
            loading: false,
            costumers: [],
            sections: [],
            order: {},
            order_items: [],
        }
    },
    beforeMount() {
        this.getOrderDetailById(this.orderId);
        this.getCostumerSections();
    },
    mounted() {
        console.log(this.orderId);
    },
    methods: {
        getOrderDetailById(id) {
            this.loading = true;
            let me = this;
            axios.get('/order/get-details/' + id)
            .then(response => {
                console.log(response);
                me.order = response.data.order;
                me.order_items = response.data.order_items;
            })
            .catch(error => {
                console.log(error);
            });
        },
        getCostumerSections() {
            let me = this;
            axios.get('/order/get-costumers-sections/')
            .then(res => {
                console.log(res);
                me.costumers = res.data.costumers;
                me.sections = res.data.sections;
                me.loading = false;
            })
            .catch(err => {
                console.log(err);
            });
        },
        // Costumer
        handleChangeCostumer(value) {
            console.log(`selected ${value}`);
        },
        removeCostumer(value){
            console.log(`deselected ${value}`);
        },
        handleBlurCostumer() {
            console.log('blur');
        },
        handleFocusCostumer() {
            console.log('focus');
        },
        filterOptionCostumer(input, option) {
            return (
                option.componentOptions.children[0].text.toLowerCase().indexOf(input.toLowerCase()) >= 0
            );
        },
        // Section
        handleChangeSection(value, section) {
            console.log(`selected ${value}`);
            console.log(section);
            
            axios.get('/order/getSection/' + value)
            .then(response => {
                console.log(response.data.data);
                section.price = response.data.data.price;
            })
            .catch(error => {
                console.log(error);
            });
        },
        handleBlurSection() {
            console.log('blur');
        },
        handleFocusSection() {
            console.log('focus');
        },
        filterOptionSection(input, option) {
            return (
                option.componentOptions.children[0].text.toLowerCase().indexOf(input.toLowerCase()) >= 0
            );
        },
        onChangeQuantity(value) {
            console.log('changed', value);
        },

        removeOrderItem(orderItemId) {
            console.log(orderItemId);
            let me = this;
            axios.get('/order/delete-order-item/' + orderItemId)
            .then(response => {
                console.log(response);
                me.$message.success('Se elimino correctamente');
                me.getOrderDetailById(me.orderId);
                me.getCostumerSections();
            })
            .catch(error => {
                console.log(error);
            });
        },

        handleSubmit(e) {
            e.preventDefault();
            let me = this;
            // console.log(this.order);
            // console.log(this.order_items);

            axios.post('/order/update', {
                order: me.order,
                order_items: me.order_items
            })
            .then(function(res) {
                console.log(res);
                if(res.data.res == 200) {
                    me.$notification['success']({
                        message: 'Actualización Exitosa!',
                        description: 'Se han guardado sus ultimos cambios!',
                    });
                    me.getOrderDetailById(me.orderId);
                    me.getCostumerSections();
                } else {
                    me.$notification['warning']({
                        message: 'Algo salio mal',
                        description: 'Verifique ingresar todos los datos solicitados e intentelo de nuevo.',
                    });
                }
            })
            .catch(function(err) {
                console.log(err);
            });
        }
    },
}
</script>