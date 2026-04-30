<script setup lang="ts">
import {ref} from "vue"
import Header from "../components/Header.vue"
import TextFeatureForm from "../components/TextareaForm.vue"
import MemoCard from "@/components/MemoCard.vue";
import Appfooter from "../components/footer.vue"

const memoListRef = ref(null)

function onSaveComplete() {
    if (memoListRef.value) {
        memoListRef.value.fetchData()
    }
}

</script>



<template>
        <div>
            <Header />
            <TextFeatureForm title="新しいメモ" @response="onSaveComplete" />
            <MemoCard ref="memoListRef"/>
            <Appfooter />
        </div>
</template>
