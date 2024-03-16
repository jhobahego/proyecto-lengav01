<template>
  <AppLayout title="Proyectos">
    <template #header>
      <div v-if="action === 'show'"
        class="overflow-hidden h-48 w-full bg-cover flex flex-col items-center justify-center">
        <h1 class="font-bold text-6xl text-[#00447b] leading-tight text-center">
          Proyectos
        </h1>
        <p class="text-[#00447b] font-medium text-2xl text-center opacity-75">Toda la información acerca de los
          proyectos
          llevados acabo por el semillero SUIS</p>
      </div>
      <div v-else-if="action === 'create'"
        class="overflow-hidden h-48 w-full bg-cover flex flex-col items-center justify-center">
        <h1 class="font-bold text-4xl mb-2 text-[#00447b] leading-tight text-center">
          Inscripción de Proyectos
        </h1>
        <p class="text-[#00447b] font-medium text-xl text-center opacity-75">Participa en un proyecto, junto con el
          semillero SUIS</p>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <section class="max-w-5xl mx-auto mt-10">
            <Modal :show="modal" :max-width="'lg'" :closeable="true" @close="showModal">
              <CreateProject @add-item="onCreate" @show-modal="showModal" v-if="action === 'create'"
                :users="props.users" />

              <EditProject @update-item="onEdit" @show-modal="showModal" v-if="action === 'edit'"
                :project="selectedProject" :users="props.users" />
            </Modal>

            <div v-if="projects.length === 0 && action === 'show'" class="text-center">
              <p>No hay proyectos registrados</p>
            </div>

            <header class="flex items-center justify-between p-4 m-4 mb-2">
              <h1 class="text-4xl font-bold">Proyectos</h1>
              <button @click="onClickCreate"
                class="p-3 bg-[#00447b] cursor-pointer border-none text-white rounded-lg">Crear
                proyecto</button>
            </header>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 justify-items-center m-4">
              <ListOfProjects :projects="projects" @on-click-edit="editProject" />
            </div>
          </section>
        </div>
      </div>
    </div>
  </AppLayout>
</template>


<script setup lang="ts">
import { ref, Ref, onMounted } from 'vue';
import CreateProject from '../Components/Projects/CreateProject.vue';
import ListOfProjects from '../Components/Projects/ListOfProject.vue';
import EditProject from '../Components/Projects/EditProject.vue';
import AppLayout from '../Layouts/AppLayout.vue';
import Modal from '../Components/Modal.vue';
import { type Project, type User } from '../types/types.d';
import Swal from 'sweetalert2';

const props = defineProps<{
  users: User[];
  projects: Project[];
}>();

const projects: Ref<Project[]> = ref(props.projects);
const selectedProject: Ref<Project> = ref(projects.value[0]);

const action = ref<'create' | 'edit'>();
const modal = ref(false);

function showModal(val: boolean) {
  modal.value = val;
}

function onClickCreate() {
  action.value = 'create';
  modal.value = true;
}

function onCreate(project: Project) {
  projects.value.push(project);

  Swal.fire({
    title: 'Proyecto creado',
    text: 'El proyecto se ha creado con éxito',
    icon: 'success',
    confirmButtonText: 'Aceptar',
  }).then(() => {
    modal.value = false;
  })
}

function editProject(id: number) {
  const project = projects.value.find((p) => p.id === id);
  if (!project) {
    alert('No se encontró el proyecto');
    return;
  }

  selectedProject.value = project;
  modal.value = true;
  action.value = 'edit';
}

function onEdit(project: Project) {
  const index = projects.value.findIndex((p) => p.id === project.id);
  if (index < 0) return;

  projects.value[index] = project;
}

onMounted(() => {
  projects.value = props.projects;
});

</script>
