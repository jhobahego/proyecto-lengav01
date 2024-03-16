<template>
  <section class="max-w-5xl mx-auto mt-10">
    <header>
      <h1 class="text-4xl font-bold text-center">Edición de proyecto</h1>
    </header>
    <form @submit.prevent="submitForm(project.id)"
      class="form-projects rounded-lg flex flex-col items-center p-7 relative">
      <button type="button" @click="emit('showModal', false)"
        class="fixed bg-[#dc3545] cursor-pointer text-white p-2 mb-3 rounded-lg size-10 top-5 right-5">X</button>
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
            placeholder="Escribe tu objetivo general..." :id="`general-${index}`">{{ obj }}</textarea>
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
          <option v-for="(obj, index) of projectTypes" :key="index" :value="obj"
            :selected="obj === formData.project_type">{{ obj }}
          </option>
        </select>
      </label>

      <label for="project_status" class="flex flex-col w-full mb-3">Estado del proyecto
        <select v-model="formData.project_status" class="rounded-lg mt-1" id="project_status" name="project_status">
          <option v-for="status in projectStatus" :key="status" :value="status">{{ status }}</option>
        </select>
      </label>

      <label for="manager" class="flex flex-col w-full mb-3">Responsable
        <select v-model="formData.manager" class="rounded-lg mt-1" id="manager" name="manager">
          <option v-for="user in users" :key="user.id" :value="user.id" :selected="user.id === formData.manager">{{
      user.name }}</option>
        </select>
      </label>

      <label for="start_date" class="flex flex-col w-full mb-3">Fecha de inicio
        <input v-model="formData.start_date" type="date" class="rounded-lg mt-1" id="start_date" name="start_date">
      </label>

      <label for="end_date" class="flex flex-col w-full mb-3">Fecha de finalizacion
        <input v-model="formData.end_date" type="date" class="rounded-lg mt-1" id="end_date" name="end_date">
      </label>

      <label for="project_link" class="flex flex-col w-full mb-3">Enlace del proyecto
        <input v-model="formData.project_link" type="text" class="rounded-lg mt-1" id="project_link"
          name="project_link">
      </label>

      <label for="portrait_url" class="flex flex-col w-full mb-3">URL de la imagen
        <input v-model="formData.portrait_url" type="text" class="rounded-lg mt-1" id="portrait_url"
          name="portrait_url">
      </label>

      <button type="submit" class="w-[80%] mx-auto bg-blue-700 text-white rounded-md mt-3 p-3 font-bold text-lg">Editar
        proyecto</button>
      <button type="button" @click="emit('showModal', false)"
        class="w-[80%] mx-auto cursor-pointer border-none bg-[#dc3545] text-white p-2 mb-3 rounded-md">Cancelar
        edición</button>
    </form>
  </section>
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { type User, type Project } from '../../types/types.d';

const props = defineProps<{
  project: Project;
  users: User[];
}>();

const emit = defineEmits({
  showModal: (val: boolean) => val,
  updateItem: (val: Project) => val,
});

let formData = ref<Project>({
  ...props.project,
  end_date: formatDates(props.project.end_date),
  start_date: formatDates(props.project.start_date)
});

const projectTypes = ref(['INNOVACIÓN', 'INVESTIGACIÓN', 'EXTENSIÓN', 'EMPRENDIMIENTO']);
const projectStatus = ref(["EN_CURSO", "FINALIZADO", "PENDIENTE"]);

function submitForm(id: number) {
  const form = useForm(formData.value);

  emit('updateItem', formData.value)

  form.put(route('projects.update', id)), {
    onFinish: () => {
      form.reset('title', 'description', 'general_objectives', 'specific_objectives', 'project_type', 'project_status', 'manager', 'start_date', 'end_date', 'project_link', 'portrait_url');
    }
  };

  emit('showModal', false);
}

function addGeneralObjective() {
  formData.value.general_objectives.push('');
}

function removeGeneralObjective() {
  if (formData.value.general_objectives.length > 1) {
    formData.value.general_objectives.pop();
  }
}

function addSpecificObjective() {
  formData.value.specific_objectives.push('');
}

function removeSpecificObjective() {
  if (formData.value.specific_objectives.length > 1) {
    formData.value.specific_objectives.pop();
  }
}

function mapProjectToFormData(project: Project) {
  formData.value = { ...project };

  const general_objectives = JSON.parse(JSON.stringify(project.general_objectives));
  const specific_objectives = JSON.parse(JSON.stringify(project.specific_objectives));

  formData.value.general_objectives = JSON.parse(general_objectives);
  formData.value.specific_objectives = JSON.parse(specific_objectives);

  formData.value.start_date = project.start_date !== null ? formatDates(project.start_date) : '';
  formData.value.end_date = project.end_date !== null ? formatDates(project.end_date) : '';
}

function formatDates(date: string) {
  const newDate = new Date(date);
  const year = newDate.getFullYear();
  const month = String(newDate.getMonth() + 1).padStart(2, '0');
  const day = String(newDate.getDate()).padStart(2, '0');
  return `${year}-${month}-${day}`;
}

onMounted(() => {
  mapProjectToFormData(props.project);
});
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
</style>