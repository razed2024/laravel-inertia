<script setup>
import { Head, Link, useForm, router } from "@inertiajs/vue3";



const props = defineProps({
    skill: Object,
});

const form = useForm({
    skillName: props.skill?.skillName,
    image: null,
});

const submit = () =>{
    router.post(`/admin/skill/update/${props.skill.id}`, {
  _method: 'put',
  skillName: form.skillName,
  image: form.image,
})
}



</script>

<template>
   
        <Head title="Skill Edit" />
        <h2 class="text-xl text-blue-700 leading-tight text-center">
            Skill Edit Page
        </h2>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="relative overflow-x-auto">
                <form @submit.prevent="submit" class="max-w-lg mx-auto">
                    <div class="mb-5">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Skill Name</label>
                        <input 
                            required
                            type="text" 
                            id="name" 
                            v-model="form.skillName" 
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                        />
                        <div class="text-red-400 text-sm" v-if="form.errors.skillName">{{ form.errors.skillName }}</div>
                     </div>

                    <div class="mb-5">
                        <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Image Upload</label>
                        <input 
                            type="file" 
                            id="image" 
                            @change="form.image = $event.target.files[0]" 
                            class="bg-white-50 border border-gray-50 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                         <div class="text-red-400 text-sm" v-if="form.errors.image">{{ form.errors.image }}</div>

                        <div v-if="props.skill.image" class="mt-4">
                            <img :src="`/${props.skill.image}`" alt="Current Image" class="w-32 h-32 object-cover rounded-lg border border-gray-300" />
                        </div>
                    </div>

                    <button 
                        type="submit" 
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Update
                    </button>
                </form>
            </div>
        </div>
  
</template>

<style>
/* Your additional styles here */
</style>