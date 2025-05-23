<script setup>
import { ref } from "vue";
import {useBuildQuery} from '@/Composables/useBuildQuery.js'
import AppLayout from '@/layouts/AppLayout.vue';
import {router } from '@inertiajs/vue3';
const props  = defineProps({
    tags: Object,
    title:String,
    search_title:String,
    is_admin:Boolean,
    trash:Boolean,
});
const params = ref({
    search_title:'',
})
const filter = () => {
    const endpoint = ref(useBuildQuery(route('tag.index'),params.value));
    router.get(endpoint.value);
}
</script>
<template>
    <AppLayout>
       <div class="flex flex-wrap mt-4">
         <div class="w-full mb-12 px-4">
            <div class="relative flex flex-col min-w-0 break-words w-full mb-6 ">
                <div class="rounded-t mb-0 px-3 py-4 border-0">
                    <div class="flex flex-wrap items-center">
                        <div class="relative flex">
                            <div class="flex items-center">
                                <h3 class="font-bold text-lg">
                                    {{title}} 
                                </h3>
                                <div class="flex items-center ml-10 max-w-[300px] relative">
                                    <TextInput type="text" class="mt-1 !py-1 block w-full" v-model="params.search_title" @change="filter"  placeholder="Search by title..." />
                                    <i class="fa fa-search absolute right-2 text-gray-400 top-3"></i>
                                </div>
                            </div>
                        </div>
                        <div class="fixed bottom-3 right-3 lg:bottom-0 lg:right-0 lg:relative ml-auto flex flex-col gap-3 lg:block">
                            <SecondaryLink  :href="route('tag.create')" class="size-10 lg:size-auto  lg:px-3 lg:py-2 flex items-center justify-center gap-2 !rounded-full lg:!rounded-none lg:!rounded-l-md">
                            <i class="fa fa-pencil"></i>
                            <span class="hidden lg:block">Create New</span>
                            </SecondaryLink>
                            <SecondaryLink  :href="route('tag.index', { trash:'1' })" class="size-10 lg:size-auto  lg:px-3 lg:py-2 flex items-center justify-center gap-2 !rounded-full lg:!rounded-none lg:!rounded-r-md bg-red-500">
                            <i class="fa fa-trash-can"></i>
                            <span class="hidden lg:block">Trash</span>
                            </SecondaryLink>
                        </div>
                    </div>
                </div>
                <div class="block w-full overflow-x-auto">
                <table class="items-center w-full bg-transparent border-collapse">
                    <thead>
                    <tr class="hidden lg:table-row">
                        <Th>Title</Th>
                        <Th>Published Date</Th>
                        <Th></Th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(tag,index) in tags.data" :key="index" class="cursor-pointer relative py-3 block lg:py-0 lg:table-row border-t lg:border-0">
                        <Td>
                            <strong class="block lg:hidden">Title</strong>
                            <Badge
                            class="!text-xs !py-1 !px-2"
                            :style="{ backgroundColor: tag.color, color: tag.text_color }"
                            >
                            {{ tag.title }}
                            </Badge>
                        </Td>
                        <Td>
                            <strong class="block lg:hidden">Published Date</strong>
                            <span>{{tag.published_at ?? '-'}}</span>
                        </Td>
                        <Td >
                            <div v-if="trash">
                                <SecondaryLink  class="px-3 py-2 bg-green-500 rounded-none rounded-l-md" :href="route('tag.restore', { tag:tag })" method="post" as="button">
                                    <i class="fas fa-rotate-right"></i>
                                </SecondaryLink>
                                <SecondaryLink  class="px-3 py-2 bg-red-500 rounded-none rounded-r-md" :href="route('tag.forceDelete', { tag:tag })" method="post" as="button">
                                    <i class="fas fa-trash-can"></i>
                                </SecondaryLink>
                            </div>
                            <div v-else>
                                <SecondaryLink  class="px-3 py-2 bg-indigo-500 rounded-none rounded-l-md" :href="route('tag.edit', { tag:tag })">
                                    <i class="fas fa-pencil"></i>
                                </SecondaryLink>
                                <SecondaryLink  class="px-3 py-2 bg-red-500 rounded-none rounded-r-md" :href="route('tag.delete', { tag:tag })" method="post" as="button">
                                    <i class="fas fa-trash-can"></i>
                                </SecondaryLink>
                            </div>
                        </Td>
                    </tr>
                    </tbody>
                </table>
                 <pagination class="mt-6" :links="tags.meta.links" />
                </div>
            </div>
         </div>
       </div>
   </AppLayout>
</template>
