<script setup>
import model from '@/modules/section/models/contact';
import View from '@/modules/section/components/View.vue';
</script>

<template>
    <View :pageTitle="__('Contact')" name="contact" type="page" :model="model" />
</template>

