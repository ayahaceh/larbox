<script setup>
import { Page } from '@/core/base/page';
import { UpdateConfig } from '@/core/crud/config';
import model from '@/modules/user/models/user';

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
                title: this.__('Редактирование'),
                breadcrumbs: [
                    {
                        label: this.__('Пользователи'),
                        path: 'user/user',
                    },
                ],
            }),
            config: new UpdateConfig({
                model: model,
                http: {
                    path: 'user/user/:id',
                },
                titleField: 'username',
                redirectPath: 'user/user',
                afterSubmit: (context, formData, response) => {
                    toastr.success(context.__('Запись успешно сохранена'));

                    if (this.$route.params.id == this.booted.user.id) {
                        this.booted.helpers.user.login(this, formData.get('username'), formData.get('new_password'));
                        context.booted.components.app.childKey++;
                    }
                },
            }),
        };
    },
};
</script>

<template>
    <PageTitle :text="page.title">
        <Buttons />
    </PageTitle>

    <Update />
</template>
