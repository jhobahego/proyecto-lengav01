<template>
  <form @submit.prevent="submitForm(props.event.id)" class="relative">
    <button class="fixed top-3 right-3 bg-red-600/80 rounded-full p-3 text-white" type="button"
      @click="setCloseModal">X</button>
    <h1 class="text-2xl my-3">Editar evento</h1>
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

    <button class="bg-blue-700 py-2 px-4 font-bold text-white w-full max-w-xs roundend-md" type="submit">Editar</button>
    <button class="bg-red-600 py-2 px-4 font-bold text-white w-full max-w-xs roundend-md" type="button"
      @click="setCloseModal">Cancelar</button>
    <button class="bg-red-600 py-2 px-4 font-bold text-white w-full max-w-xs roundend-md" type="button"
      @click="deleteEvent(props.event.id)">Eliminar evento</button>
  </form>
</template>


<script setup lang="ts">
import { ref, Ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { type Event, type User } from '../../types/types.d';


const props = defineProps<{
  users: User[];
  event: Event;
}>();

const emit = defineEmits({
  closeModal: (val: boolean) => val,
  updateItem: (val: Event) => val,
  deleteItem: (val: number) => val,
});

function setCloseModal() {
  emit('closeModal', true);
}

let form: Ref<Event> = ref<Event>({
  ...props.event,
  id: 0
});

function submitForm(id: number) {
  const formData = useForm({
    ...form.value,
    remember: false
  });

  emit('updateItem', form.value);

  formData.put(`events/${id}`, {
    onFinish: () => {
      formData.reset('title', 'description', 'activity_type', 'manager', 'start', 'end', 'link', 'location', 'duration', 'color');
    },
  });

  emit('closeModal', true);
}

function deleteEvent(id: number) {
  const formData = useForm({
    ...form.value,
    remember: false
  });

  emit('deleteItem', id)

  if (confirm('¿Estas seguro que deseas eliminar este evento?')) {
    formData.delete(`events/${id}`, {
      onFinish: () => {
        formData.reset('title', 'description', 'activity_type', 'manager', 'start', 'end', 'link', 'location', 'duration', 'color');
      },
    });

    emit('closeModal', true);
  }
}
</script>