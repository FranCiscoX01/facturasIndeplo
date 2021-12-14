<template>
    <div class="row mx-0 d-flex justify-content-center">
        <div class="col-md-8">
            <fieldset>
                <a-spin tip="Creando Pedido..." :spinning="loading">
                    <legend>Pedido:</legend>
                    <a-form :form="form" @submit.prevent="handleSubmit">
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
                                @deselect="removeCostumer"
                                :required="true"
                                v-decorator="[
                                    `costumer`,
                                    {
                                        rules: [
                                        {
                                            required: true,
                                            message: 'Por favor seleccione un cliente.',
                                        },
                                        ],
                                    },
                                ]"
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
                            <a-form-item
                            v-for="(k, index) in form.getFieldValue('keys')"
                            :key="k"
                            v-bind="index === 0 ? formItemLayout : formItemLayoutWithOutLabel"
                            :label="index === 0 ? '' : ''"
                            :required="true"
                            >
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
                                        @change="handleChangeSection($event, k)"
                                        allowClear
                                        v-decorator="[
                                            `section[${k}]`,
                                            {
                                                rules: [
                                                {
                                                    required: true,
                                                    message: 'Por favor seleccione articulo o elimine el articulo completo.',
                                                },
                                                ],
                                            },
                                        ]"
                                    >
                                        <a-select-option v-for="s in sections" :key="s.id">
                                            {{ s.code }} - {{ s.name }}
                                        </a-select-option>
                                    </a-select>
                                </div>
                                <div class="form-group form-row">
                                    <div class="col">
                                        <label for="quantity">Cantidad</label>
                                        <a-input-number id="quantity" style="width: 100%" :min="1" 
                                            v-decorator="[
                                                `quantity[${k}]`,
                                                {
                                                    rules: [
                                                    {
                                                        required: true,
                                                        message: 'Por favor ingrese la cantidad o elimine el articulo completo.',
                                                    },
                                                    ],
                                                },
                                            ]" 
                                            @change="onChangeQuantity($event, k)" 
                                        />
                                    </div>
                                    <div class="col">
                                        <label for="costumer">Precio</label>
                                        <br>
                                        <h5 style="margin-bottom: 0 !important; line-height: inherit !important;">{{ new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'USD' }).format(price[k]) }}</h5>
                                    </div>
                                </div>
                                
                                <a-button 
                                    type="danger" 
                                    icon="delete" 
                                    size="large" 
                                    v-if="form.getFieldValue('keys').length > 1"
                                    :disabled="form.getFieldValue('keys').length === 1"
                                    @click="() => remove(k)"
                                />
                            </a-form-item>
                            <a-form-item v-bind="formItemLayoutWithOutLabel">
                                <a-button type="dashed" style="width: 100%" @click="add">
                                    <a-icon type="plus" /> Agregar Articulo
                                </a-button>
                            </a-form-item>
                        </fieldset>

                        <div class="form-group text-right">
                            <a-button type="primary" html-type="submit" >
                                Crear Pedido
                            </a-button>
                        </div>
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
.dynamic-delete-button {
    cursor: pointer;
    position: relative;
    top: 4px;
    font-size: 24px;
    color: #999;
    transition: all 0.3s;
}
.dynamic-delete-button:hover {
    color: #777;
}
.dynamic-delete-button[disabled] {
    cursor: not-allowed;
    opacity: 0.5;
}
</style>
<script>
let id = 0;
export default {
    props: {
        costumers: Array,
        sections: Array
    },
    data() {
        return {
            order: {
                costumer: null,
                code: "",
            },
            price: [],
            aux_price: [],
            loading:false,
            formItemLayout: {
                labelCol: {
                    xs: { span: 24 },
                    sm: { span: 4 },
                },
                wrapperCol: {
                    xs: { span: 24 },
                    sm: { span: 24 },
                },
            },
            formItemLayoutWithOutLabel: {
                wrapperCol: {
                    xs: { span: 24, offset: 0 },
                    sm: { span: 20, offset: 4 },
                },
            },
        }
    },
    beforeCreate() {
        this.form = this.$form.createForm(this, { name: 'dynamic_form_item' });
        this.form.getFieldDecorator('keys', { initialValue: [], preserve: true });
    },
    mounted() {
        
    },
    methods: {
        // Costumer
        handleChangeCostumer(value) {
            console.log(`selected ${value}`);
            this.order.costumer = value;
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
        handleChangeSection(value, k) {
            console.log(`selected ${value}`);
            let me = this;
            let i = id - 1;
            axios.get('/order/getSection/' + value)
            .then(response => {
                console.log(response.data.data);
                me.price[k] = response.data.data.price;
                me.aux_price[k] = response.data.data.price;
                console.log(me.price);
            })
            .catch(error => {
                console.log(error);
            });
            // this.order.section.push({
            //     id: value,

            // });
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

        // send Order
        sendOrder() {
            // console.log(this.order);
            this.form.validateFields((err, values) => {
                if (!err) {
                const { keys, names } = values;
                console.log('Received values of form: ', values);
                console.log(
                    'Merged values:',
                    keys.map(key => names[key]),
                );
                }
            });
        },
        handleSubmit(e) {
            let me = this;
            this.loading = true;
            e.preventDefault();
            this.form.validateFields((err, values) => {
                if (!err) {
                    const { keys, names } = values;
                    console.log('Received values of form: ', values);
                    // console.log(
                    //     'Merged values:',
                    //     keys.map(key => names[key]),
                    // );

                    axios.post('/order/store', {
                        data: values,
                        costumer: me.order.costumer,
                        code: me.order.code
                    })
                    .then(response => {
                        console.log(response);
                        if(response.data.response == 200) {
                            me.form.resetFields();
                            me.order.code = "";
                            me.$notification['success']({
                                message: 'Creación Exitosa!',
                                description: 'Se ha creado el registro exitosamente!',
                            });
                        } else {
                            me.$notification['warning']({
                                message: 'Algo salio mal',
                                description: 'Verifique ingresar todos los datos solicitados e intentelo de nuevo.',
                            });
                        }
                    })
                    .catch(error => {
                        console.log(error);
                    });
                }
                me.loading = false;
            });
        },

        onChangeQuantity(value, k) {
            console.log('changed', value);
            this.price[k] = this.aux_price[k] * value;
        },
        onChangeTotal(value) {
            console.log('changed', value);
        },
        remove(k) {
            const { form } = this;
            // can use data-binding to get
            const keys = form.getFieldValue('keys');
            // We need at least one passenger
            if (keys.length === 1) {
                return;
            }

            // can use data-binding to set
            form.setFieldsValue({
                keys: keys.filter(key => key !== k),
            });
        },

        add() {
            const { form } = this;
            // can use data-binding to get
            const keys = form.getFieldValue('keys');
            const nextKeys = keys.concat(id++);
            // can use data-binding to set
            // important! notify form to detect changes
            form.setFieldsValue({
                keys: nextKeys,
            });
        },
    },
}
</script>