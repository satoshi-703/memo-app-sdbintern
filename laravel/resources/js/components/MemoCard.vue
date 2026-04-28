<script setup lang="ts">
import DocumentSvg  from "@/components/svgs/DocumentSvg.vue";
import TextareaForm from "@/components/TextareaForm.vue";
import { ref, onMounted,computed } from 'vue'
import TrashSvg from "@/components/svgs/TrashSvg.vue";

const MemoData  = ref(null)

const memoCount = computed(() => {
    if (!MemoData.value) return 0
    return MemoData.value.filter((t) => t.deleted === false).length
})

async function fetchData() {
    MemoData.value = null
    const res = await fetch(
        'http://localhost:48080/api/memos/')
    MemoData.value = await res.json()
}

// script setup内に追加
async function deletedMemo(id: number) {
    console.log('削除するID:', id);
    // 本来はここで fetch(url, { method: 'DELETE' }) を呼ぶ
    alert('削除ボタンが押されました（ID: ' + id + '）');
}

onMounted(() => {
    fetchData()
})

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
<!--                <TextareaForm @response="fetchData" />-->
                <li v-for="memo in MemoData" :key="memo.id">
                    <div class="card">
                        <p>{{memo.content}}</p>
                        <p>{{memo.created_at}}</p>
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
