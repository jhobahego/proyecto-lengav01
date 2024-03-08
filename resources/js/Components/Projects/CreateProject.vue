<template>
  <section class="max-w-5xl mx-auto mt-10">
    <header>
      <h1 class="text-4xl font-bold text-center">Creación de proyectos</h1>
    </header>
    <form @submit.prevent="submitForm" class="form-projects rounded-lg flex flex-col items-center p-7">
      <label for="title" class="flex flex-col w-full mb-3">Titulo
        <input v-model="form.title" type="text" class="rounded-lg mt-1"
          placeholder="Creación de un videojuego 2d para mejorar los procesos de aprendizaje" id="title" name="title">
      </label>

      <label for="description" class="flex flex-col w-full mb-3">Descripcion
        <textarea v-model="form.description" class="rounded-lg mt-1" id="description"
          placeholder="Proyecto creado para mejorar los procesos..." name="description"></textarea>
      </label>

      <div class="flex flex-col items-center mb-2 w-full">
        <h5 class="left">Objetivos generales</h5>

        <label v-for="(obj, index) in form.general_objectives" :key="index" :for="`general-${index}`"
          class="flex flex-col w-full mb-3">
          #{{ index + 1 }} objetivo general
          <textarea class="rounded-lg mt-1" v-model="form.general_objectives[index]"
            placeholder="Escribe tu objetivo general..." :id="`general-${index}`"></textarea>
        </label>

        <div class="flex items-center gap-2">
          <button type="button" @click="addGeneralObjective" class="p-2 rounded-md bg-blue-700 text-white">Agregar
            objetivo</button>
          <button v-if="form.general_objectives.length > 1" type="button" @click="removeGeneralObjective"
            class="bg-red-600 text-white p-2 m-3 rounded-md">Eliminar objetivo</button>
        </div>
      </div>

      <div class="flex flex-col items-center mb-2 w-full">
        <h5 class="left">Objetivos especificos</h5>

        <label v-for="(obj, index) in form.specific_objectives" :key="index" :for="`specific-${index}`"
          class="flex flex-col w-full mb-3">
          #{{ index + 1 }} objetivo especifico
          <textarea class="rounded-lg mt-1" v-model="form.specific_objectives[index]"
            placeholder="Escribe tu objetivo especifico..." :id="`specific-${index}`"></textarea>
        </label>

        <div class="flex items-center gap-2">
          <button type="button" @click="addSpecificObjective" class="p-2 rounded-md bg-blue-700 text-white">Agregar
            objetivo</button>
          <button v-if="form.specific_objectives.length > 1" type="button" @click="removeSpecificObjective"
            class="bg-red-600 text-white p-2 m-3 rounded-md">Eliminar objetivo</button>
        </div>
      </div>

      <label for="project_type" class="flex flex-col w-full mb-3">Tipo de proyecto
        <select v-model="form.project_type" class="rounded-lg mt-1" id="project_type" name="project_type">
          <option v-for="type in projectTypes" :key="type" :value="type">{{ type }}</option>
        </select>
      </label>

      <label for="project_status" class="flex flex-col w-full mb-3">Estado del proyecto
        <select v-model="form.project_status" class="rounded-lg mt-1" id="project_status" name="project_status">
          <option v-for="status in projectStatus" :key="status" :value="status">{{ status }}</option>
        </select>
      </label>

      <label for="manager" class="flex flex-col w-full mb-3">Responsable
        <select v-model="form.manager" class="rounded-lg mt-1" id="manager" name="manager">
          <option v-for="user in props.users" :key="user.id" :value="user.id">{{ user.name }}</option>
        </select>
      </label>

      <label for="start_date" class="flex flex-col w-full mb-3">Fecha de inicio
        <input v-model="form.start_date" type="date" class="rounded-lg mt-1" id="start_date" name="start_date">
      </label>

      <label for="end_date" class="flex flex-col w-full mb-3">Fecha de finalizacion
        <input v-model="form.end_date" type="date" class="rounded-lg mt-1" id="end_date" name="end_date">
      </label>

      <label for="project_link" class="flex flex-col w-full mb-3">Enlace del proyecto
        <input v-model="form.project_link" type="text" class="rounded-lg mt-1" id="project_link" name="project_link">
      </label>

      <label for="portrait_url" class="flex flex-col w-full mb-3">URL de la imagen
        <input v-model="form.portrait_url" type="text" class="rounded-lg mt-1" id="portrait_url" name="portrait_url">
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
import { type Project, type User } from '@/types/types';

let formData = useForm({
  id: 0,
  title: '',
  description: '',
  general_objectives: [''],
  specific_objectives: [''],
  project_type: 'INVESTIGACION',
  project_status: 'PENDIENTE',
  manager: 0,
  start_date: '',
  end_date: '',
  project_link: '',
  portrait_url: ''
});

const form = ref<Project>({
  id: 0,
  title: '',
  description: '',
  general_objectives: [''],
  specific_objectives: [''],
  project_type: 'INVESTIGACION',
  project_status: 'PENDIENTE',
  manager: 0,
  start_date: '',
  end_date: '',
  project_link: '',
  portrait_url: ''
});

const projectTypes = ref(['INNOVACION', 'INVESTIGACION', 'EXTENSION', 'EMPRENDIMIENTO']);
const projectStatus = ref(["EN_CURSO", "FINALIZADO", "PENDIENTE"]);

type Action = 'create' | 'edit' | 'show';

const props = defineProps<{
  users: User[];
}>();

const emit = defineEmits({
  showModal: (act: Action) => act,
  addItem: (val: Project) => val,
});

async function submitForm() {
  emit('addItem', form.value);

  await useForm(form.value).post('projects', {
    onFinish: () => {
      formData.reset('title', 'description', 'general_objectives', 'specific_objectives', 'project_type', 'project_status', 'manager', 'start_date', 'end_date', 'project_link', 'portrait_url');
    },
  });

  emit('showModal', 'show');
}

function addGeneralObjective() {
  form.value.general_objectives.push('');
}

function removeGeneralObjective() {
  if (form.value.general_objectives.length > 1) {
    form.value.general_objectives.pop();
  }
}

function addSpecificObjective() {
  form.value.specific_objectives.push('');
}

function removeSpecificObjective() {
  if (form.value.specific_objectives.length > 1) {
    form.value.specific_objectives.pop();
  }
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