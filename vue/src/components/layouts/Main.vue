<script setup>
import init from '@/core/app/init';
import { RouterView } from 'vue-router';

import TopBar from './particles/main/TopBar.vue';
import SideBar from './particles/main/SideBar.vue';
</script>

<script>
export default {
    data() {
        return {
            templateKey: 0,
            isReady: false,
        };
    },
    beforeCreate() {
        this.booted.components.layout = this;
    },
    created() {
        $('#preloader').addClass('active');

        init(this).then(() => {
            document.documentElement.setAttribute('lang', this.booted.locale);
            document.getElementById('favicon').href = this.booted.settings.favicon;

            this.booted.helpers.http
                .send(this, {
                    method: 'GET',
                    path: 'user/profile',
                })
                .then((response) => {
                    if (response.statusType === 'success') {
                        this.booted.user = response.data;

                        this.booted.helpers.http
                            .send(this, {
                                method: 'GET',
                                path: 'information/enums',
                            })
                            .then((response2) => {
                                if (response2.statusType === 'success') {
                                    $('#preloader').removeClass('active');

                                    this.booted.enums = response2.data;
                                    this.isReady = true;
                                }
                            });
                    }
                });
        });
    },
};
</script>

<template>
    <template v-if="isReady">
        <TopBar :templateKey="templateKey" id="qwe" />
        <SideBar :templateKey="templateKey" />

        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <RouterView />
                </div>
            </section>
        </div>

        <footer class="main-footer">
            <b>Copyright &copy; {{ new Date().getFullYear() }}</b>
            <div class="float-right d-none d-sm-inline-block">All rights reserved</div>
        </footer>
    </template>
</template>
