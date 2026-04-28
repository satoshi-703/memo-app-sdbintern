<script setup lang="ts">
import PlusSvg from "../components/svgs/PlusSvg.vue"
import { ref } from 'vue'

const memo = ref(''
)

const emit = defineEmits(['response']);

// csrf

async function saveMemo() {
    const metaTag = document.querySelector('meta[name="csrf-token"]');

    let csrfToken = '';

    if (metaTag) {
        csrfToken = metaTag.getAttribute('content') || '';
    }

    const data = {
        content: memo.value
    };

    const response = await fetch('/api/memos', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken},
        body: JSON.stringify(data)
    })

    if (response.ok) {
        memo.value = ''
        emit('response', 'stored');
    }
}

function isEmpty(a) {
    return a === '';
}

defineProps({
    title: String
});
</script>

<template>
    <div class="card">
        <h1 class="title">
            <PlusSvg />新しいメモ
        </h1>
        <textarea
            v-model="memo"
            rows="5"
            placeholder="メモを入力してください..."/>
<!--        <p>isEmpty結果: {{ isEmpty(memo) }}</p>-->
        <button @click="saveMemo" :disabled="isEmpty(memo)" class="savebutton">
            <PlusSvg />メモを保存
        </button>
    </div>
</template>

<style scoped>
.card {
    width: 50%;
    background-color: white;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 16px;
    margin: 30px auto 0 auto;
}
textarea {
    width: 100%;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 8px;
    font-size: 0.9rem;
    resize: none;
}

.title {
    display: flex;
    justify-content: flex-start;
    //align-items: center;
    gap: 8px;
    font-size: 1.2rem;
}

.savebutton {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 12px;
    border: none;
    font-size: 1.0rem;
    font-weight: bold;
    color: white;
    cursor: pointer;
    background: linear-gradient(to right, #FDBA74, #F87171);
}

.savebutton:disabled {
    background: linear-gradient(to right, #D1D5DB, #9CA3AF);
    cursor: not-allowed;
    opacity: 0.6;
}

</style>
