<script setup>

import Row from "@/Components/Row.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";

defineProps(['board'])
</script>

<template>
    <GuestLayout>
        <div class="board flex flex-col">
            <Row v-for="row in board.data.rows" :key="row.id" :row :board />
        </div>
    </GuestLayout>
</template>

<style scoped>

</style>
