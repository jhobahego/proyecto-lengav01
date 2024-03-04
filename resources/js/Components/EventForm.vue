<template>
  <form @submit.prevent="submitForm(props.event?.id)" class="relative">
    <h1 class="text-2xl my-3">{{ props.event !== undefined ? 'Agendar evento' : 'Editar evento' }}</h1>
    <label class="w-full text-left">Titulo
      <input v-model="form.title" type="text" name="title" class="w-full">
    </label>
    <label class="w-full text-left">Descripcion
      <textarea v-model="form.description" type="text" name="description" class="w-full"></textarea>
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
    <label v-if="form.end" class="w-full text-left">Fecha de finalización
      <input v-model="form.end" type="datetime-local" name="end_date" class="w-full">
    </label>
    <label class="w-full text-left">Duración del evento (minutos)
      <input v-model="form.duration" type="text" name="duration" class="w-full">
    </label>
    <label class="w-full text-left">Color
      <input v-model="form.color" type="color" name="color" class="w-full">
    </label>

    <button class="fixed top-3 right-3" @click="setCloseModal">Cerrar</button>
    <button class="bg-blue-700 py-2 px-4 font-bold text-white w-full max-w-xs" type="submit">{{ props.event !== undefined ? 'Agregar' : 'Editar'
    }}</button>
    <button class="bg-red-600 py-2 px-4 font-bold text-white w-full max-w-xs" @click="setCloseModal">Cerrar</button>
  </form>
</template>


<script setup lang="ts">
import { ref, Ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';


enum activity_type {
  'online',
  'in-person',
  'hybrid'
}

interface Event {
  id: number;
  title: string;
  manager: string;
  description: string;
  activity_type: activity_type;
  link?: string;
  location?: string;
  start: string;
  end?: string;
  duration: string;
  color: string;
}

const emit = defineEmits({
  closeModal: (val: boolean) => val
});

function setCloseModal() {
  emit('closeModal', true);
}

const props = defineProps({
  event: {
    type: Object as () => Event,
    required: false,
  }
});

let form: Ref<Event> = ref<Event>({
  id: -1,
  title: '',
  description: '',
  activity_type: activity_type.online,
  manager: '1',
  start: '',
  end: '',
  link: '',
  location: '',
  duration: '',
  color: 'blue'
});

function submitForm(id: number | undefined) {
  if (id === undefined) {
    alert('No se ha seleccionado un evento');
    return;
  }
  const formData = {
    ...form.value,
    remember: false
  };

  useForm(formData).put(`events/${id}`, {
    onFinish: () => {
      console.log('Form submitted');
    },
  });
}

onMounted(() => {
  form.value = props.event || form.value;
});
</script>