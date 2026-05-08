<script setup lang="ts">
import DocumentSvg  from "@/components/svgs/DocumentSvg.vue";
import { ref, computed } from 'vue'
import TrashSvg from "@/components/svgs/TrashSvg.vue";
import editSvg from "@/components/svgs/editSvg.vue";
import EditModal from "@/components/EditModal.vue";
import RestorationModal from "@/components/RestorationModal.vue";

const isModalOpen = ref(false);
const targetMemo = ref<any>(null);
const isRestoreModalOpen = ref(false);

const props = defineProps({
    memos: {
        type: Array,
        default: () => []
    }
})

const emit = defineEmits(['updated']);

const displayMemos = computed(() => {
    return props.memos.filter((memo) => memo.deleted === 0)
})

const memoCount = computed(() => {
    return props.memos.filter((t) => t.deleted === 0).length
})

const editMemo = (memo: any) => {
    targetMemo.value = memo;
    isModalOpen.value = true;
};




async function deletedMemo(id: number) {

    const metaTag = document.querySelector('meta[name="csrf-token"]');
    const csrfToken = metaTag?.getAttribute('content') || '';

    const response = await fetch(`http://localhost:48080/api/memos/${id}`,{
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }});

    if (response.ok) {
        emit('updated');
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
    <div class="container">
        <div class="title">
            <DocumentSvg />保存されたメモ
            <div class="number">
                <button
                    @click="isRestoreModalOpen = true"
                    class="trash-bin-btn"
                    title="ゴミ箱を見る"
                >
                    <p class="flex items-center gap-2 text-gray-700">
                        <TrashSvg class="w-5 h-5 text-gray-500" />
                        <span class="whitespace-nowrap">削除されたメモ</span>
                    </p>

                </button>
                <span class="px-3 py-1 rounded-full bg-primary-100 text-gray-600 text-sm border border-primary-200 shadow-sm">
                    {{memoCount}}件
                </span>
            </div>
        </div>
            <ul v-if="memos.length">

                <li v-for="memo in displayMemos" :key="memo.id">
                    <div class="card">
                        <p style="white-space: pre-wrap;">{{memo.content}}</p>
                        <p class="text-sm text-gray-400">{{ formatDate(memo.created_at)}}</p>

                        <div class="card-actions">
                            <button class="edit-btn" @click="editMemo(memo)">
                                <editSvg />
                            </button>
                            <button class="deleted-btn" @click="deletedMemo(memo.id)">
                                <TrashSvg />
                            </button>
                        </div>
                    </div>
                </li>
            </ul>

            <RestorationModal
                :is-open="isRestoreModalOpen"
                :memos="memos"
                @close="isRestoreModalOpen = false"
                @updated="emit('updated')"
            />

            <EditModal
                :is-open="isModalOpen"
                :memo-data="targetMemo"
                @close="isModalOpen = false"
                @updated="emit('updated')"
            />
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
    margin: 0px auto 10px auto;
}

.number {
    font-size: 20px;
    display: flex;
    margin-left: auto;
    gap: 12px;
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

.card-actions {
    position: absolute;
    top: 20px;
    right: 20px;
    display: flex;
    gap: 8px;
    opacity: 0;
    transition: opacity 0.2s;
}

.edit-btn, .deleted-btn {
    background: none;
    border: none;
    cursor: pointer;
    padding: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: black;
    transition: transform 0.1s;
}

.card:hover .card-actions {
    opacity: 1;
}

</style>
