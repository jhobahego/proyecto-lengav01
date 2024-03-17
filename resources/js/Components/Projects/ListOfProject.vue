<template>
  <Link v-for="project in projects" :key="project.id" :href="`/projects/${project.id}`"
    class="card w-[80%] md:w-full border text-black border-blue-500 shadow-md rounded-lg p-4 flex flex-col min-h-72">
  <h2 class="text-xl md:text-2xl font-semibold mb-2">{{ project.title }}</h2>
  <p class="text-base md:text-lg text-gray-600">{{ project.description }}</p>
  <div class="flex justify-between items-center my-4 gap-x-3">
    <span class="text-xs lg:text-base">{{ project.project_type }}</span>
    <span class="text-xs lg:text-base">{{ project.project_status }}</span>
  </div>
  </Link>
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