<script setup>
import { Page } from '@/core/base/page';
import { UpdateConfig } from '@/core/crud/config';
import model from '@/modules/system/models/settings';

import PageTitle from '@/components/blocks/PageTitle.vue';
import Buttons from '@/components/crud/form/particles/Buttons.vue';
import Update from '@/components/crud/Update.vue';
</script>

<script>
export default {
    data() {
        return {
            page: new Page({
                context: this,
                title: this.__('Настройки'),
            }),
            config: new UpdateConfig({
                model: model,
                http: {
                    path: 'system/settings',
                },
                redirectPath: 'system/settings',
                afterSubmit: (context, formData, response) => {
                    toastr.success(context.__('Настройки успешно сохранены'));
                    context.booted.components.app.childKey++;
                },
            }),
        };
    },
};
</script>

<template>
    <PageTitle :text="page.title">
        <Buttons :actions="['save']" />
    </PageTitle>

    <Update />
</template>
