<script setup>
import { pickBy } from 'lodash';

import Input from '@/components/Input.vue';
import Sort from './index/particles/Sort.vue';
import SoftDelete from './index/particles/SoftDelete.vue';
import Grid from './index/Grid.vue';
</script>

<script>
export default {
    data() {
        return {
            config: this.booted.components.current.config,
            model: this.booted.components.current.config.model,
            filterId: 'el-' + this.booted.helpers.string.uniqueId(),
            items: {},
            dataKey: 0,
        };
    },
    created() {
        // Page init

        this.booted.components.current.page.init();

        // Collecting active filters

        let query = this.$route.query,
            values = {};

        query = Object.fromEntries(Object.entries(query).filter(([key, value]) => key.includes('filter[')));

        for (let key in query) {
            key = key.replace('filter[', '', key);

            if (key.includes('][')) {
                let keyArr = key.split('][');

                let firstKey = keyArr[0];
                let lastKey = keyArr[1].replace(']', '');

                values[firstKey] ??= {};
                values[firstKey][lastKey] = query['filter[' + key];
            } else {
                values[key.replace(']', '')] = query['filter[' + key];
            }
        }

        // Collecting items

        this.items = this.model.prepareFilters(this, this.model.filters, values);
    },
    methods: {
        submit(event) {
            let formData = new FormData(event.target),
                query = {},
                queryIndex = 0;

            formData.forEach((value, key) => {
                if (key.includes('[]')) {
                    key = key.replace('[]', '[' + queryIndex + ']');
                    queryIndex++;
                }

                query[key] = value;
            });

            this.$router
                .push({
                    path: this.$route.path,
                    query: pickBy(query),
                })
                .then(() => {
                    this.dataKey++;
                });
        },
        reset(event) {
            this.$router
                .push({
                    path: this.$route.path,
                })
                .then(() => {
                    $(event.target).find('input, textarea, select').val('').trigger('change');
                    this.dataKey++;
                });
        },
    },
};
</script>

<template>
    <div class="card card-primary mb-3" v-if="config.showFilter">
        <div
            class="card-header d-flex align-items-center justify-content-between"
            role="button"
            data-toggle="collapse"
            :data-target="'#' + filterId"
        >
            <h3 class="card-title w-100">
                {{ __('Фильтр') }}
            </h3>

            <i class="fas fa-angle-down"></i>
        </div>

        <div :id="filterId" class="collapse show">
            <form @submit.prevent="submit" @reset.prevent="reset">
                <div class="card-body">
                    <div class="row">
                        <template v-for="(item, key) in items">
                            <Input :item="item" />
                        </template>

                        <Sort v-if="model.sortings.length > 0" :fields="model.sortings" />
                        <SoftDelete v-if="config.hasSoftDelete" />
                    </div>
                </div>

                <div class="card-footer text-right">
                    <div class="btn-group">
                        <button type="reset" class="btn btn-danger">
                            {{ __('Сбросить') }}
                        </button>

                        <button type="submit" class="btn btn-primary">
                            {{ __('Применить') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <Grid :key="dataKey" />
</template>
