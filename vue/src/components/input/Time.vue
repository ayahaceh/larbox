<script>
export default {
    props: {
        item: {
            type: Object,
            required: true,
        },
    },
    mounted() {
        $('#' + this.item.id)
            .daterangepicker({
                autoUpdateInput: false,
                singleDatePicker: true,
                showDropdowns: true,
                autoApply: true,
                minYear: 1901,
                maxYear: parseInt(moment().format('YYYY')) + 10,
                timePicker: true,
                timePicker24Hour: true,
                locale: {
                    format: 'HH:mm',
                },
            })
            .on('show.daterangepicker', function (ev, picker) {
                picker.container.find('.calendar-table').hide();
            })
            .on('apply.daterangepicker', function (ev, picker) {
                let value = picker.startDate.format(picker.locale.format);
                $(this).val(value);
            });
    },
};
</script>

<template>
    <input type="text" />
</template>
