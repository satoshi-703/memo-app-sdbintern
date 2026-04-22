<script setup lang="ts">
import Welcome from "../features/Welcome.vue";
import Header from "../components/Header.vue"
import TextFeatureForm from "../components/TextareaForm.vue"
import FeatureCard from "../components/FeatureCard.vue"
</script>

<template>
        <div>
            <Header />
            <TextFeatureForm title="新しいメモ" />
        </div>
</template>
