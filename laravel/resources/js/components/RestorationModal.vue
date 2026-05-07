<script setup lang="ts">
    import { computed } from 'vue'

    const props = defineProps({
        isOpen: Boolean,
        memos: Object
    })

    const emit = defineEmits(['close', 'updated'])

    const deletedMemos = computed(() => {
        return props.memos?.filter((memo) => memo.deleted === 1)
    })

    async function restoreMemo(id: number) {
        const metaTag = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = metaTag?.getAttribute('content') || '';

        const response = await fetch(`http://localhost:48080/api/memos/${id}/restore`,{
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        })

        if (response.ok) {
            emit('updated')
        }
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

</script>

<template>
    <div v-if="isOpen" class="modal-overlay" @click.self="$emit('close')">
        <div class="modal-card">
            <h2>ゴミ箱</h2>

            <div class="deleted-list">
                <div v-if="deletedMemos.length === 0" class="empty-msg">
                    削除されたメモはありません。
                </div>

                <div v-for="memo in deletedMemos" :key="memo.id" class="deleted-item">
                    <div class="memo-preview">
                        <p>{{ memo.content }}</p>
                        <p>{{ formatDate(memo.created_at)}}</p>
                    </div>
                    <button @click="restoreMemo(memo.id)" class="restore-btn">
                        復元
                    </button>
                </div>
            </div>

            <div class="modal-buttons">
                <button @click="$emit('close')" class="close-btn">閉じる</button>
            </div>
        </div>
    </div>
</template>

<style scoped>
.modal-overlay {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0,0,0,0.5);
    display: flex; justify-content: center; align-items: center;
    z-index: 1100;
}

.modal-card {
    background: white; padding: 24px; border-radius: 16px;
    width: 90%; max-width: 500px;
    max-height: 70vh;
    display: flex;
    flex-direction: column;
}

.deleted-list {
    margin: 20px 0;
    overflow-y: auto;
    flex-grow: 1;
}

.deleted-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px;
    border-bottom: 1px solid #eee;
    gap: 15px;
}

.memo-preview p {
    margin: 0;
    font-size: 0.9rem;
    color: #666;
    white-space: pre-wrap;
}

.restore-btn {
    flex-shrink: 0;
    padding: 6px 16px;
    border: none;
    border-radius: 20px;
    background: #10b981;
    color: white;
    font-weight: bold;
    cursor: pointer;
    font-size: 0.8rem;
}

.close-btn {
    width: 100%;
    padding: 10px;
    border: none;
    background: #f3f4f6;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
}

.empty-msg {
    text-align: center;
    color: #999;
    padding: 20px;
}
</style>
