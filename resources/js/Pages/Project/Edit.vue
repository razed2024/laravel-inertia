<script setup>
import { Head, Link, useForm, router } from "@inertiajs/vue3";

  const props = defineProps({
    skills: Array,
    project: Object,

});

const form = useForm({
  projectName: props.project?.projectName,
  image: null,
  skill_id: props.project?.skill_id,
  project_url: props.project?.project_url,
});

const submit = () =>{
   
    router.post(`/admin/project/update/${props.project.id}`,
        {
            _method:'put',
            projectName: form.projectName,
            image: form.image,
            skill_id: form.skill_id,
            project_url: form.project_url,
        });

}

</script>

<template>
    <div>
        
        <Head title="project-edit" />
        <h2 class="text-xl text-blue-700 leading-tight text-center">
            Project Edit Page
        </h2>

        <div class="w-full pb-5">
            <Link :href="route('projects.index')"
                type="button"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" >
                Project Page
            </Link>
        </div>

        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <div class="relative overflow-x-auto">


                <form @submit.prevent="submit" class="max-w-lg mx-auto">
                    <!-- name -->
                    <div class="mb-5">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">project name</label>
                        <input type="text" id="projectName" v-model="form.projectName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write Project name"/>
                        <div class="text-red-400 text-sm" v-if="errors && errors.projectName">{{ errors.projectName }}</div>
                    </div>

                    <!-- skill -->
                    <div class="mb-5">
                        <label for="skill" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Skill name</label>
                        <select v-model="form.skill_id" id="skill_id" name="skill_id" 
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option v-for="skill in skills" :key="skill.id" :value="skill.id"> {{ skill.skillName}} </option>
                        </select>
                        <div class="text-red-400 text-sm" v-if="errors && errors.skill_id">{{ errors.skill_id }}</div>
                    </div>


                    <!-- project url -->
                    <div class="mb-5">
                        <label for="project_url" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Project Url</label>
                        <input type="text" id="project_url" v-model="form.project_url" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write Project url"/>
                        <div class="text-red-400 text-sm" v-if="errors && errors.project_url">{{ errors.project_url }}</div>
                    </div>

                   <!-- project image -->

                    <div class="mb-5">
                        <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Image Upload</label>
                        <input type="file" id="image" @input="form.image = $event.target.files[0]" class="bg-white-50 border border-gray-50 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>

                        <div class="text-red-400 text-sm" v-if="errors && errors.image">{{ errors.image }}</div>
                    </div>
                    
                    <div v-if="props.project.image" class="mt-4">
                            <img :src="`/${props.project.image}`" alt="Current Image" class="w-32 h-32 object-cover rounded-lg border border-gray-300" />
                        </div>

                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-3">
                        Update
                    </button>
                    
                </form>
            </div>
        </div>


    </div>
</template>

<style scoped>

</style>