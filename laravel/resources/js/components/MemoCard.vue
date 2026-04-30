<script setup lang="ts">
import DocumentSvg  from "@/components/svgs/DocumentSvg.vue";
import { ref, computed } from 'vue'
import TrashSvg from "@/components/svgs/TrashSvg.vue";

const MemoData  = ref([])

const displayMemos = computed(() => {
    if (!MemoData.value) return 0
    return MemoData.value.filter((memo) => memo.deleted === 0)
})

const memoCount = computed(() => {
    if (!MemoData.value) return 0
    return MemoData.value.filter((t) => t.deleted === 0).length
})

async function fetchData() {
    // MemoData.value = []
    const res = await fetch(
        'http://localhost:48080/api/memos/')
    MemoData.value = await res.json()
}

// script setup内に追加
async function deletedMemo(id: number) {
    const response = await fetch(`http://localhost:48080/api/memos/${id}`,{method: 'PATCH',body: JSON.stringify({ deleted: 1 })});
    await fetchData();
}

const formatDate = (dateString: string) => {
    if (!dateString) return ''

    const date = new Date(dateString);

    return date.toLocaleString('ja-JP', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
    });
}

 defineExpose({
     fetchData
 });

</script>

<template>
    <div class="container">
        <div class="title">
            <DocumentSvg />保存されたメモ
            <div class="number">
                {{memoCount}}件
            </div>
        </div>
            <ul v-if="MemoData">

                <li v-for="memo in displayMemos" :key="memo.id">
                    <div class="card">
                        <p>{{memo.content}}</p>
                        <p>{{ formatDate(memo.created_at)}}</p>
                        <button class="deleted-btn" @click="deletedMemo(memo.id)">
                            <TrashSvg />
                        </button>
                    </div>
                </li>
            </ul>


    </div>
</template>

<style scoped>
.container {
    width: 50%;
    margin: 0 auto;
}

.title {
    font-size: 20px;
    display: flex;
    justify-content: flex-start;
    margin: 30px auto 10px auto;
}

.number {
    font-size: 20px;
    display: flex;
    margin-left: auto;
}

.card {
    position: relative;
    background-color: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 16px;
    margin: 0 auto 10px auto;
}

.deleted-btn {
    position: absolute;
    top: 20px;
    right: 20px;
    opacity: 0;
    color: black;
    transition: opacity 0.2s;
    cursor: pointer;
}

.card:hover .deleted-btn {
    opacity: 1;
}

</style>
