<script>
export default {
    inheritAttrs: false,
    props: {
        item: {
            type: Object,
            required: true,
        },
        id: {
            type: Number,
            required: true,
        },
    },
    data() {
        return {
            currentValue: this.item.value,
        };
    },
    mounted() {
        $('#' + this.item.id).bootstrapSwitch('state', $('#' + this.item.id).prop('checked'));

        $('#' + this.item.id).on('switchChange.bootstrapSwitch', (event, state) => {
            let path = this.item.options.path.replace(':id', this.id).replace(':value', state ? 1 : 0);

            this.booted.helpers.http
                .send(this, {
                    method: 'PATCH',
                    path: path,
                })
                .then((response) => {
                    if (response.statusType === 'success') {
                        this.currentValue = state;

                        if (this.item.options.onSuccess) {
                            this.item.options.onSuccess(this, this.currentValue);
                        }
                    } else {
                        $('#' + this.item.id).bootstrapSwitch('state', this.currentValue, true);
                    }
                });
        });
    },
};
</script>

<template>
    <input
        type="checkbox"
        v-bind="item.attributes"
        :id="item.id"
        :checked="currentValue"
        data-bootstrap-switch
        data-on-text="<i class='fas fa-check'></i>"
        data-off-text="<i class='fas fa-times'></i>"
        data-on-color="success"
        data-off-color="danger"
    />
</template>
