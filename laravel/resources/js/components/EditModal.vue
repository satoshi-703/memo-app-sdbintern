<script setup lang="ts">
import { ref, watch } from 'vue'


const props = defineProps({
    isOpen: Boolean,
    memoData: Object
})

const emit = defineEmits(['close', 'updated'])
const editedContent = ref('')

watch(() => props.isOpen, (newVal) => {
    if (newVal && props.memoData) {
        editedContent.value = props.memoData.content
    }
})

async function updateMemo() {
    const metaTag = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = metaTag?.getAttribute('content')||'';

    const response = await fetch(`http://localhost:48080/api/memos/${props.memoData?.id}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ content: editedContent.value })
    })

    if (response.ok) {
        emit('updated')
        emit('close')
    }
}

</script>

<template>
    <div v-if="isOpen" class="modal-overlay" @click.self="$emit('close')">
        <div class="modal-card">
            <h2>メモを編集</h2>
            <textarea v-model="editedContent" rows="5"></textarea>
            <div class="modal-buttons">
                <button @click="updateMemo" class="savebutton">更新する</button>
                <button @click="$emit('close')" class="cancel-btn">キャンセル</button>
            </div>
        </div>
    </div>
</template>

<style scoped>
textarea {
    width: 100%;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 8px;
    font-size: 0.9rem;
    resize: none;
}

.modal-overlay {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0,0,0,0.5);
    display: flex; justify-content: center; align-items: center;
    z-index: 1000;
}
.modal-card {
    background: white; padding: 24px; border-radius: 16px; width: 90%; max-width: 500px;
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
