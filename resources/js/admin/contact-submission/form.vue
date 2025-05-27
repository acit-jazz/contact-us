<script setup>
import { useForm } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";

let props = defineProps({
  tag: Object,
  type: [String, Boolean],
  method: String,
  title:String,
  is_admin:Boolean,
});

const form = ref(useForm(props.tag));

onMounted(() => {
  form.value.type = props.type;
});

const submit = () => {
  const routes = {
    post: route('tag.store', form.value.id),
    patch: route('tag.update', { tag : props.tag.id ?  props.tag : '0' }),
  };

  const action = routes[props.method];
  if (!action) return;
  form.value[props.method](action, {
    preserveScroll: false,
    onFinish: () => console.log("ok"),
    onSuccess: (res) => {
      if (props.method === 'post') {
        form.value.reset();
      } else if (props.method === 'update') {
        form.value = useForm(res.props.tag);
      }
    },
  });
};

const tab = ref("content");
const changeTab = (newtab) => {
  tab.value = newtab;
};
</script>

<template>
    <Head :title="title" />
    <AppLayout>
        <div>
          <form class="flex flex-wrap mt-4 text-black" @submit.prevent="default">
            <div class="w-full lg:w-8/12">
                <div class="relative flex flex-col min-w-0 break-words w-full mb-6 px-5 rounded" >
                    <div class="block w-full overflow-x-auto">
                        <div class="rounded-t mb-5">
                            <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-blueGray-300">
                                <ul class="flex flex-wrap -mb-px">
                                    <li class="mr-2">
                                        <a @click="changeTab('content')" class="inline-block cursor-pointer font-bold p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-800 hover:border-gray-600 dark:hover:text-gray-600"
                                        :class="{'!border-blue-600  text-blue-600 active dark:text-blue-500 dark:border-blue-500' : tab == 'content'}"
                                        aria-current="product">Content</a>
                                    </li>
                                    <li class="mr-2">
                                        <a @click="changeTab('seo')"  class="inline-block cursor-pointer font-bold p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-800 hover:border-gray-600 dark:hover:text-gray-600"
                                        :class="{'!border-blue-600  text-blue-600 active dark:text-blue-500 dark:border-blue-500' : tab == 'seo'}"
                                        >SEO</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="block w-full overflow-x-auto lg:px-4" :class="{hidden : tab != 'content'}">
                            <div class="block">
                                <InputLabel for="title" value="Title" />
                                <TextInput type="text" class="mt-1 block w-full" v-model="form.title"  />
                                <InputError class="mt-2" :message="form.errors.title" />
                            </div>

                            <div class="block mt-4">
                                <InputLabel for="slug" value="Slug" />
                                <InputSlug  type="text" class="mt-1 block w-full" :source="form.title" v-model="form.slug"  />
                                <InputError class="mt-2" :message="form.errors.slug" />
                            </div>
                            <div class="block mt-4">
                                <InputLabel :for="form.summary" value="Summary" />
                                <TextAreaInput  class="mt-1 block w-full" v-model="form.summary"  />
                            </div>
                            <div class="block mt-4">
                                <InputLabel for="description" value="Description" />
                                <tiny-editor
                                placeholder="Description"
                                v-model="form.description"
                                ></tiny-editor>
                                <InputError
                                class="mt-2"
                                :message="form.errors.description"
                                />
                            </div>
                        </div>
                        <div class="block w-full overflow-x-auto lg:px-4" :class="{hidden : tab != 'seo'}">
                                <div class="block">
                                    <InputLabel :for="form.meta.title" value="Meta Title" />
                                    <TextInput type="text" class="mt-1 block w-full" v-model="form.meta.title"  />
                                </div>

                                <div class="block mt-4">
                                    <InputLabel :for="form.meta.description" value="Meta Description" />
                                    <TextAreaInput  class="mt-1 block w-full" v-model="form.meta.description"  />
                                </div>

                                <div class="block mt-4">
                                    <InputLabel :for="form.meta.image" value="Meta Image" />
                                    <acit-jazz-upload
                                    class="mt-1 block w-full"
                                    title="meta"
                                    folder="meta"
                                    :limit="1"
                                    filetype="image/*"
                                    name="meta"
                                    v-model="form.meta.image"
                                    >
                                    </acit-jazz-upload>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full lg:w-4/12">
                <div class="relative flex flex-col min-w-0 break-words w-full rounded px-5">
                    <div class="block mt-4">
                        <InputLabel for="published_at" value="Published Date" />
                        <TextInput
                        type="datetime-local"
                        v-model="form.published_at"
                        format="dd/MM/yyyy hh:mm"
                        placeholder="Select Published Date"
                        />
                        <InputError class="mt-2" :message="form.errors.published_at" />
                    </div>
                    <div class="block mt-4">
                        <InputLabel for="color" value="Color" />
                        <InputColor  type="text" class="mt-1 block w-full" :source="form.color" v-model="form.color"  />
                        <InputError class="mt-2" :message="form.errors.color" />
                    </div>
                    <div class="block mt-4">
                        <InputLabel for="text_color" value="Text Color" />
                        <InputColor  type="text" class="mt-1 block w-full" :source="form.text_color" v-model="form.text_color"  />
                        <InputError class="mt-2" :message="form.errors.text_color" />
                    </div>
                    <div class="block mt-4">
                        <InputLabel :for="form.images" value="Images" />
                        <acit-jazz-upload
                        class="mt-1 block w-full"
                        title="images"
                        folder="tag"
                        :limit="1"
                        filetype="image/*"
                        name="images"
                        v-model="form.images"
                        >
                        </acit-jazz-upload>
                    </div>
                </div>
            </div>
            <div class="px-5 w-full mt-5 mb-10">
                <PrimaryButton  @click="submit" class="w-full block cursor-pointer text-center py-3 px-3 justify-center rounded-md">
                    Save
                </PrimaryButton>
            </div>
      </form>
    </div>
  </AppLayout>
</template>
