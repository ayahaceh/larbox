<script setup>
import { Page } from '@/core/base/page';
import { IndexConfig } from '@/core/crud/config';
import model from '@/modules/box/models/tag';

import PageTitle from '@/components/blocks/PageTitle.vue';
import RouterLink from "@/components/blocks/RouterLink.vue";
import Index from '@/components/crud/Index.vue';
</script>

<script>
export default {
    data() {
        return {
            page: new Page({
                context: this,
                title: this.__('Tags'),
            }),
            config: new IndexConfig({
                model: model,
                http: {
                    path: 'box/tag',
                },
                selectionActions: ['deleteAll', 'restoreAll'],
                hasSoftDelete: true,
            }),
        };
    },
};
</script>

<template>
    <PageTitle :text="page.title">
        <RouterLink to="box/tag/create" class="btn btn-success">
            {{ __('Создать') }}
        </RouterLink>
    </PageTitle>

    <Index />
</template>
