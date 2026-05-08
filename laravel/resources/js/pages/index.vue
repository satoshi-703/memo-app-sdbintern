<script setup lang="ts">
import {ref, onMounted, computed} from "vue"
import Header from "../components/Header.vue"
import TextFeatureForm from "../components/TextareaForm.vue"
import MemoCard from "@/components/MemoCard.vue";
import Appfooter from "../components/footer.vue"

const memos = ref([])
const searchQuery = ref("")


async function fetchData() {
    try {
        let url = 'http://localhost:48080/api/memos/'
        if (searchQuery.value) {
            url += `?q=${encodeURIComponent(searchQuery.value)}`
        }

        const res = await fetch(url)
        memos.value = await res.json()
    } catch (e) {
        console.error("データの取得に失敗", e)
    }
}

onMounted(fetchData)

function onSaveComplete() {
    fetchData()
}

</script>



<template>
        <div>
            <Header />
            <TextFeatureForm title="新しいメモ" @response="onSaveComplete" />

            <MemoCard :memos="memos" @updated="fetchData" />
            <Appfooter />
        </div>
</template>
