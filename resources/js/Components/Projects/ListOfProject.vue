<template>
  <article v-for="project in projects" :key="project.id"
    class="card border border-blue-500 shadow-md rounded-lg p-4 flex flex-col max-w-80 sm:max-w-full min-h-72">
    <h2 class="text-2xl font-semibold mb-2">{{ project.title }}</h2>
    <p class="text-gray-600">{{ project.description }}</p>
    <div class="flex justify-between items-center my-4">
      <span class="text-sm">{{ project.project_type }}</span>
      <span class="text-sm">{{ project.project_status }}</span>
    </div>
    <div class="flex gap-x-2 justify-center mt-auto">
      <Link :href="`/projects/${project.id}`"
        class="p-2 bg-[#00447b] cursor-pointer border-none text-white rounded">Visitar</Link>
      <button @click="editProject(project)" class="p-2 bg-yellow-500 text-white rounded">Editar</button>
      <button @click="deleteProject(project)"
        class="p-2 bg-[#dc3545] cursor-pointer border-none text-white rounded">Eliminar</button>
    </div>
  </article>
</template>

<script setup lang="ts">
import { Project } from '../../types/types';
import { useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import Swal from 'sweetalert2';

const props = defineProps<{
  projects: Project[];
}>();

const emit = defineEmits({
  onClickEdit: (id: number) => id,
})

const projects = ref(props.projects);

function editProject(project: Project) {
  emit('onClickEdit', project.id);
}

function deleteProject(project: Project) {
  Swal.fire({
    title: '¿Estás seguro?',
    text: 'Esta acción no se puede deshacer',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      const form = useForm(project);
      form.delete(`projects/${project.id}`, {
        onFinish: () => {
          form.reset('title', 'description', 'general_objectives', 'specific_objectives', 'project_type', 'project_status', 'manager', 'start_date', 'end_date', 'project_link', 'portrait_url');
          projects.value = projects.value.filter((p) => p.id !== project.id);
          Swal.fire('Éxito', 'El proyecto se ha eliminado correctamente', 'success').then(() => {
            window.location.reload();
          });
        },
      });
    }
  });
}

</script>

<style scoped>
.card {
  background: linear-gradient(to bottom, rgba(245, 245, 245, 0.5), rgba(26, 108, 141, 0.87));
}
</style>