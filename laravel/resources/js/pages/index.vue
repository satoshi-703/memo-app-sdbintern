<script setup lang="ts">
import {ref, onMounted} from "vue"
import Header from "../components/Header.vue"
import TextFeatureForm from "../components/TextareaForm.vue"
import MemoCard from "@/components/MemoCard.vue";
import Appfooter from "../components/footer.vue"

const memos = ref([])

async function fetchData() {
    try {
        const res = await fetch('http://localhost:48080/api/memos/')
        memos.value = await res.json()
    } catch (e) {
        console.error("データの取得に失敗", e)
    }
}

onMounted(fetchData)

function onSaveComplete() {
    fetchData()
}


//
// const memoListRef = ref(null)
//
// function onSaveComplete() {
//     if (memoListRef.value) {
//         memoListRef.value.fetchData()
//     }
// }

</script>



<template>
        <div>
            <Header />
            <TextFeatureForm title="新しいメモ" @response="onSaveComplete" />
            <MemoCard :memos="memos" @updated="fetchData" />
            <Appfooter />
        </div>
</template>
