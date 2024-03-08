<template>
  <form @submit.prevent="submitForm" class="relative">
    <button class="fixed top-3 right-3 bg-red-600/80 rounded-full p-3 text-white" type="button"
      @click="setCloseModal">X</button>
    <h1 class="text-2xl my-3">Agendar evento</h1>
    <label class="w-full text-left">Titulo
      <input v-model="form.title" type="text" name="title" class="w-full">
    </label>
    <label class="w-full text-left">Descripcion
      <textarea v-model="form.description" type="text" name="description" class="w-full"></textarea>
    </label>
    <label class="w-full text-left">Encargado
      <select v-model="form.manager" name="manager" class="w-full">
        <option v-for="user in props.users" :key="user.id" :value="user.id">{{ user.name }}</option>
      </select>
    </label>
    <label class="w-full text-left">Tipo de actividad
      <select v-model="form.activity_type" name="activity_type" class="w-full">
        <option value="online">Online</option>
        <option value="in-person">Presencial</option>
      </select>
    </label>
    <label v-if="form.activity_type.toString() === 'online'" class="w-full text-left">Link
      <input v-model="form.link" type="text" name="link" class="w-full">
    </label>
    <label v-if="form.activity_type.toString() === 'in-person'" class="w-full text-left">Ubicación
      <input v-model="form.location" type="text" name="location" class="w-full">
    </label>
    <label class="w-full text-left">Fecha de inicio
      <input v-model="form.start" type="datetime-local" name="start_date" class="w-full">
    </label>
    <label class="w-full text-left">Fecha de finalización
      <input v-model="form.end" type="datetime-local" name="end_date" class="w-full">
    </label>
    <label class="w-full text-left">Duración del evento (minutos)
      <input v-model="form.duration" type="text" name="duration" class="w-full">
    </label>
    <label class="w-full text-left">Color
      <input v-model="form.color" type="color" name="color" class="w-full">
    </label>

    <button class="bg-blue-700 py-2 px-4 font-bold text-white w-full max-w-xs rounded-md" type="submit">Agregar</button>
    <button class="bg-red-600 py-2 px-4 font-bold text-white w-full max-w-xs rounded-md" type="button"
      @click="setCloseModal">Cancelar</button>
  </form>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { type Event, activity_type, type User } from '../../types/types.d';
import Swal from 'sweetalert2';

const props = defineProps<{
  users: User[]
  dateSelected: string
}>();

const emit = defineEmits({
  closeModal: (val: boolean) => val,
  addItem: (val: Event) => val,
});

let form = ref<Event>({
  title: '',
  description: '',
  activity_type: activity_type.PRESENCIAL,
  manager: 1,
  start: formatDate(props.dateSelected),
  end: '',
  link: '',
  location: '',
  duration: '0',
  color: '#000000',
  id: 0
});

function setCloseModal() {
  emit('closeModal', true);
}

function submitForm() {
  const formData = useForm({
    ...form.value,
    remember: false
  });

  Swal.fire({
    title: 'Detalles del evento',
    html: `
      <p>Vas a crear un evento con los siguientes detalles:</p>
      <ul>
        <li><strong>Titulo:</strong> ${form.value.title}</li>
        <li><strong>Fecha de inicio:</strong> ${form.value.start}</li>
        <li><strong>Ubicación:</strong> ${form.value.location}</li>
        <li><strong>Duración:</strong> ${form.value.duration} minutos</li>
        <li><strong>Encargado:</strong> ${props.users.find(user => user.id === form.value.manager)?.name}</li>
      </ul>
    `,
    icon: 'info',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, crear evento',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      form.value.start = form.value.start.length === 0 ? "" : formatDate(form.value.start);
      form.value.end = form.value.end.length === 0 ? "" : formatDate(form.value.end);

      formData.post('events', {
        onFinish: () => {
          formData.reset('title', 'description', 'activity_type', 'manager', 'start', 'end', 'link', 'location', 'duration', 'color');
          emit('addItem', formData);
          setCloseModal();
        },
      });
    }
  });
}


function formatDate(stringDate: string) {
  const date = new Date(stringDate);
  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, '0'); // Se suma 1 ya que los meses van de 0 a 11
  const day = String(date.getDate() + 1).padStart(2, '0');
  const hours = String(date.getHours()).padStart(2, '0');
  const minutes = String(date.getMinutes()).padStart(2, '0');
  const seconds = String(date.getSeconds()).padStart(2, '0');

  return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}

</script>