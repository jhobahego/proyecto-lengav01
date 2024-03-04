<template>
  <section class="max-w-5xl mx-auto mt-10">
    <header>
      <div v-if="errors.length > 0" class="bg-red-500 text-white rounded-md p-2">
        <ul>
          <li v-for="error in errors" :key="error" class="nav-item">{{ error }}</li>
        </ul>
      </div>
      <h1 class="text-4xl font-bold text-center">Creación de proyectos</h1>
    </header>
    <form @submit.prevent="submitForm" class="form-projects rounded-lg flex flex-col items-center p-7">
      <label for="title" class="flex flex-col w-full mb-3">Titulo
        <input v-model="formData.title" type="text" class="rounded-lg mt-1"
          placeholder="Creación de un videojuego 2d para mejorar los procesos de aprendizaje" id="title" name="title">
      </label>

      <label for="description" class="flex flex-col w-full mb-3">Descripcion
        <textarea v-model="formData.description" class="rounded-lg mt-1" id="description"
          placeholder="Proyecto creado para mejorar los procesos..." name="description"></textarea>
      </label>

      <div class="flex flex-col items-center mb-2 w-full">
        <h5 class="left">Objetivos generales</h5>

        <label v-for="(obj, index) in formData.general_objectives" :key="index" :for="`general-${index}`"
          class="flex flex-col w-full mb-3">
          #{{ index + 1 }} objetivo general
          <textarea class="rounded-lg mt-1" v-model="formData.general_objectives[index]"
            placeholder="Escribe tu objetivo general..." :id="`general-${index}`"></textarea>
        </label>

        <div class="flex items-center gap-2">
          <button type="button" @click="addGeneralObjective" class="p-2 rounded-md bg-blue-700 text-white">Agregar
            objetivo</button>
          <button v-if="formData.general_objectives.length > 1" type="button" @click="removeGeneralObjective"
            class="bg-red-600 text-white p-2 m-3 rounded-md">Eliminar objetivo</button>
        </div>
      </div>

      <div class="flex flex-col items-center mb-2 w-full">
        <h5 class="left">Objetivos especificos</h5>

        <label v-for="(obj, index) in formData.specific_objectives" :key="index" :for="`specific-${index}`"
          class="flex flex-col w-full mb-3">
          #{{ index + 1 }} objetivo especifico
          <textarea class="rounded-lg mt-1" v-model="formData.specific_objectives[index]"
            placeholder="Escribe tu objetivo especifico..." :id="`specific-${index}`"></textarea>
        </label>

        <div class="flex items-center gap-2">
          <button type="button" @click="addSpecificObjective" class="p-2 rounded-md bg-blue-700 text-white">Agregar
            objetivo</button>
          <button v-if="formData.specific_objectives.length > 1" type="button" @click="removeSpecificObjective"
            class="bg-red-600 text-white p-2 m-3 rounded-md">Eliminar objetivo</button>
        </div>
      </div>

      <label for="project_type" class="flex flex-col w-full mb-3">Tipo de proyecto
        <select v-model="formData.project_type" class="rounded-lg mt-1" id="project_type" name="project_type">
          <option v-for="type in projectTypes" :key="type" :value="type">{{ type }}</option>
        </select>
      </label>

      <label for="project_status" class="flex flex-col w-full mb-3">Estado del proyecto
        <select v-model="formData.project_status" class="rounded-lg mt-1" id="project_status" name="project_status">
          <option v-for="status in projectStatus" :key="status" :value="status">{{ status }}</option>
        </select>
      </label>

      <label for="manager" class="flex flex-col w-full mb-3">Responsable
        <input v-model="formData.manager" type="number" class="rounded-lg mt-1" id="manager" name="manager">
      </label>

      <label for="start_date" class="flex flex-col w-full mb-3">Fecha de inicio
        <input v-model="formData.start_date" type="date" class="rounded-lg mt-1" id="start_date" name="start_date">
      </label>

      <label for="end_date" class="flex flex-col w-full mb-3">Fecha de finalizacion
        <input v-model="formData.end_date" type="date" class="rounded-lg mt-1" id="end_date" name="end_date">
      </label>

      <label for="project_link" class="flex flex-col w-full mb-3">Enlace del proyecto
        <input v-model="formData.project_link" type="text" class="rounded-lg mt-1" id="project_link" name="project_link">
      </label>

      <label for="portrait_url" class="flex flex-col w-full mb-3">URL de la imagen
        <input v-model="formData.portrait_url" type="text" class="rounded-lg mt-1" id="portrait_url" name="portrait_url">
      </label>

      <button type="submit" class="bg-blue-700 text-white rounded-md mt-3 p-3 font-bold text-lg">Crear proyecto</button>
      <button type="button" @click="emit('showModal', 'show')" class="btn-delete text-white p-2 m-3 rounded-md">Cancelar
        formulario</button>
    </form>
  </section>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

// const user = usePage().props.auth.user;
// console.log(user);

let formData = useForm({
  title: '',
  description: '',
  general_objectives: [''],
  specific_objectives: [''],
  project_type: 'INVESTIGACION',
  project_status: 'PENDIENTE',
  manager: -1,
  start_date: '',
  end_date: '',
  project_link: '',
  portrait_url: '',
  remember: false,
});

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

const errors = ref([]);
const projectTypes = ref(['INNOVACION', 'INVESTIGACION', 'EXTENSION', 'EMPRENDIMIENTO']);
const projectStatus = ref(["EN_CURSO", "FINALIZADO", "PENDIENTE"]);

type Action = 'create' | 'edit' | 'show';

const emit = defineEmits({
  showModal: (act: Action) => act,
});

async function submitForm() {
  formData.post('projects', {
    onFinish: () => {
      formData.reset('title', 'description', 'general_objectives', 'specific_objectives', 'project_type', 'project_status', 'manager', 'start_date', 'end_date', 'project_link', 'portrait_url');

      emit('showModal', 'show');
    },
  });
}

function addGeneralObjective() {
  formData.general_objectives.push('');
}

function removeGeneralObjective() {
  if (formData.general_objectives.length > 1) {
    formData.general_objectives.pop();
  }
}

function addSpecificObjective() {
  formData.specific_objectives.push('');
}

function removeSpecificObjective() {
  if (formData.specific_objectives.length > 1) {
    formData.specific_objectives.pop();
  }
}

function mapProjectToFormData(project: Project) {
  formData.title = project.title;
  formData.description = project.description;

  // formData.general_objectives = JSON.parse(JSON.stringify(project.general_objectives));
  // formData.specific_objectives = JSON.parse(JSON.stringify(project.specific_objectives));

  formData.project_type = project.project_type;
  formData.project_status = project.project_status;
  formData.manager = project.manager;
  formData.start_date = formatDates(project.start_date);
  formData.end_date = formatDates(project.end_date);
  formData.project_link = project.project_link;
  formData.portrait_url = project.portrait_url;
}

function formatDates(date: string) {
  const newDate = new Date(date);
  const year = newDate.getFullYear();
  const month = String(newDate.getMonth() + 1).padStart(2, '0');
  const day = String(newDate.getDate()).padStart(2, '0');
  return `${year}-${month}-${day}`;
}
</script>

<style scoped>
.form-projects {
  width: 90%;
  max-width: 800px;
  margin: 20px auto;
  gap: 14px;
  border: 1px solid #09f;
  background: linear-gradient(to bottom, rgba(245, 245, 245, 0.5), rgba(26, 108, 141, 0.87));
}

.form-projects>button {
  width: 80%;
  margin: 0 auto;
}

.btn-delete {
  background: #dc3545;
  border: none;
  cursor: pointer;
}

.input_error {
  border: 1px solid #dc3545;
}

.label_error {
  color: #dc3545;
}
</style>
