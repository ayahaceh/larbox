<script setup>
import init from '@/core/app/init';
import { RouterView } from 'vue-router';
</script>

<script>
export default {
    data() {
        return {
            isReady: false,
        };
    },
    beforeCreate() {
        $('#preloader').addClass('active');

        init(this).then(() => {
            document.documentElement.setAttribute('lang', this.booted.locale);
            document.getElementById('favicon').href = this.booted.settings.favicon;

            $('#preloader').removeClass('active');
            this.isReady = true;
        });
    },
};
</script>

<template>
    <template v-if="isReady">
        <RouterView />
    </template>
</template>
