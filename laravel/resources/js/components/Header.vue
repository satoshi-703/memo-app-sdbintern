<script setup lang="ts">

import DocumentSvg  from "@/components/svgs/DocumentSvg.vue";

</script>

<template>
    <div class="bg-white py-4">
        <header class="header">
            <h1 class="title">
                <DocumentSvg /><span class="span-orange">かんたんメモ</span></h1>
            <h6>思いついたことをサッと記録しよう</h6>
        </header>
    </div>
</template>

<style>
    .header {
        display: flex;
        align-items: center;
        flex-direction: column;
        padding: 20px 20px;
    }
    .title {
        font-size: 30px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .span-orange {
        color: rgb(249, 115, 22);
    }
</style>
