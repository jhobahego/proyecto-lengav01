<template>
  <AppLayout title="Proyectos">
    <template #header>
      <div v-if="action === 'show'"
        class="overflow-hidden h-48 w-full bg-cover flex flex-col items-center justify-center">
        <h1 class="font-bold text-6xl text-[#00447b] leading-tight text-center">
          Proyectos
        </h1>
        <p class="text-[#00447b] font-medium text-2xl text-center opacity-75">Toda la información acerca de los proyectos
          llevados acabo por el semillero SUIS</p>
      </div>
      <div v-if="action === 'create'"
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

            <ProjectForm @show-modal="showModal" :action="action" v-if="action === 'create'"
              :project="selectedProject" />

            <EditProject @show-modal="showModal" :action="action" v-if="action === 'edit'" :project="selectedProject" />

            <div v-if="projects.length === 0 && action === 'show'" class="text-center">
              <p>No hay proyectos registrados</p>
            </div>

            <header v-if="action === 'show'" class="flex items-center justify-between p-4 m-4 mb-2">
              <h1 class="text-4xl font-bold">Proyectos</h1>
              <button @click="showModal('create')" class="p-3 btn-submit text-white rounded-lg">Crear proyecto</button>
            </header>
            <div v-if="action === 'show'"
              class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 justify-items-center m-4">
              <div v-for="project in projects" :key="project.id"
                class="card border border-blue-500 shadow-md rounded-lg p-4 flex flex-col max-w-72 sm:max-w-full min-h-72">
                <h2 class="text-2xl font-semibold mb-2">{{ project.title }}</h2>
                <p class="text-gray-600">{{ project.description }}</p>
                <div class="flex justify-between items-center my-4">
                  <span class="text-sm">{{ project.project_type }}</span>
                  <span class="text-sm">{{ project.project_status }}</span>
                </div>
                <div class="flex gap-x-2 justify-end self-start mt-auto">
                  <a :href="project.project_link" target="_blank" class="p-2 btn-submit text-white rounded">Visitar</a>
                  <button @click="editProject(project.id)" class="p-2 bg-yellow-500 text-white rounded">Editar</button>
                  <button @click="deleteProject()" class="p-2 btn-delete text-white rounded">Eliminar</button>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref, Ref, onMounted } from 'vue';
import ProjectForm from '../Components/ProjectForm.vue';
import EditProject from '../Components/EditProject.vue';
import AppLayout from '../Layouts/AppLayout.vue';

interface Project {
  id: number;
  title: string;
  description: string;
  general_objectives: string[];
  specific_objectives: string[];
  portrait_url: string;
  project_type: string;
  manager: number;
  start_date: string;
  end_date: string;
  project_status: string;
  project_link: string;
}

type Action = 'create' | 'edit' | 'show';

const projects: Ref<Project[]> = ref([]);
const action: Ref<Action> = ref('create');
const selectedProject: Ref<Project> = ref(projects.value[0]);

const props = defineProps({
  projects: {
    type: Array as () => Project[],
    required: true,
  },
});

function showModal(act: Action) {
  action.value = act;
}

function editProject(id: number) {
  const project = projects.value.find((p) => p.id === id);
  if (!project) {
    alert('No se encontró el proyecto');
    return;
  }

  selectedProject.value = project;
  showModal('edit');
}

function deleteProject() {
  console.log('delete project');
}

onMounted(async () => {
  projects.value = props.projects;
  action.value = 'show';
});

</script>

<style scoped>
:root {
  --blue-principal: #00447b;
  --red-principal: #dc3545;
  --max-width: 800px;
}

.card {
  background: linear-gradient(to bottom, rgba(245, 245, 245, 0.5), rgba(26, 108, 141, 0.87));
}

.btn-submit {
  background: #00447b;
  border: none;
  cursor: pointer;
}

.btn-delete {
  background: #dc3545;
  border: none;
  cursor: pointer;
}
</style>