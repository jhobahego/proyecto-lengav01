<template>
  <AppLayout title="Proyectos">
    <template #header>
      <h1 class="font-bold text-4xl md:text-6xl text-[#00447b] leading-tight text-center">
        Detalles especificos del proyecto
      </h1>
      <p class="text-[#00447b] font-medium text-2xl text-center opacity-75">
        Toda la información especifica de este proyecto para un mejor entendimiento de lo que se trabajo en el
      </p>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <section class="card max-w-4xl mx-auto my-10 border border-solid py-8 px-14 rounded-md">
            <Modal :show="showModal" :max-width="'lg'" :closeable="true" @close="closeModal">
              <EditProject :project="project" :users="users" @update-item="onProjectEdited" @show-modal="closeModal" />
            </Modal>
            <h2 class="text-3xl md:text-5xl font-bold flex flex-col gap-y-2 text-center mb-2">
              {{ project.title }}
            </h2>

            <p class="text-xl font-medium opacity-80 mb-5">
              {{ project.description }}
            </p>

            <h3 class="text-xl md:text-2xl font-bold mb-2">
              Objetivos generales
            </h3>
            <ul class="list-disc list-inside">
              <li v-for="(obj, index) in JSON.parse(generalObjectives)" :key="index"
                class="text-lg font-medium opacity-80">
                {{ obj }}
              </li>
            </ul>

            <h3 class="text-xl md:text-2xl font-bold mb-2">
              Objetivos especificos
            </h3>
            <ul class="list-disc list-inside">
              <li v-for="(obj, index) in JSON.parse(specificObjectives)" :key="index"
                class="text-lg font-medium opacity-80">
                {{ obj }}
              </li>
            </ul>

            <div class="flex flex-col my-4">
              <span class="text-sm">Tipo de proyecto: {{ project.project_type }}</span>
              <span class="text-sm">Estado actual: {{ project.project_status }}</span>
            </div>

            <p class="text-xl font-medium mb-4">
              <strong>Asesor metodologico: </strong>
              <span>
                {{ manager.name }}
              </span>
            </p>

            <p class="text-xl font-medium">
              <strong>Fecha de inicio: </strong>
              <span>
                {{ formatDates(project.start_date) }}
              </span>
            </p>

            <p class="text-xl font-medium" v-if="project.end_date">
              <strong>Fecha de finalización: </strong>
              <span>
                {{ formatDates(project.end_date) }}
              </span>
            </p>

            <div class="flex gap-x-2 justify-end self-start mt-auto">
              <button @click="showModal = true"
                class="p-2 bg-[#00447b] cursor-pointer border-none text-white rounded">Editar proyecto</button>
              <Link :href="backUrl" class="p-2 bg-[#dc3545] cursor-pointer border-none text-white rounded">
              Volver atras</Link>
            </div>
          </section>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue';
import AppLayout from '../../Layouts/AppLayout.vue';
import { Project, User } from '../../types/types';
import { Link } from '@inertiajs/vue3';
import Modal from '../../Components/Modal.vue';
import EditProject from '../../Components/Projects/EditProject.vue';
import Swal from 'sweetalert2';


const { project, manager, users, previousUrl } = defineProps<{
  project: Project
  manager: User
  users: User[]
  previousUrl: string
}>();

const backUrl = computed(() => {
  return previousUrl === window.location.href ? '/projects' : previousUrl;
});

const generalObjectives = JSON.parse(JSON.stringify(project.general_objectives));
const specificObjectives = JSON.parse(JSON.stringify(project.specific_objectives));

function formatDates(date: string) {
  const newDate = new Date(date);
  const year = newDate.getFullYear();
  const month = String(newDate.getMonth() + 1).padStart(2, '0');
  const day = String(newDate.getDate()).padStart(2, '0');
  return `${year}-${month}-${day}`;
}

const showModal = ref(false);

function closeModal(val: boolean) {
  showModal.value = val;
}

function onProjectEdited(project: Project) {
  Swal.fire({
    title: 'Proyecto editado',
    html: `El proyecto <strong>${project.title}</strong> ha sido editado con exito`,
    icon: 'success',
    confirmButtonText: 'Aceptar'
  })
}
</script>

<style scoped>
.card {
  background: linear-gradient(to bottom, rgba(245, 245, 245, 0.5), rgba(26, 108, 141, 0.87));
}
</style>