<template>
  <section class="max-w-5xl mx-auto mt-10">
    <header>
      <h1 class="text-4xl font-bold text-center">Edición de usuarios</h1>
    </header>
    <form @submit.prevent="submitForm(props.user.id)"
      class="bg-gradient-to-b from-red-50/50 to-blue-600/80 w-[90%] mx-auto my-5 gap-3 border border-[#09f] rounded-lg flex flex-col items-center p-7 relative">
      <button type="button" @click="emit('closeModal', true)"
        class="fixed bg-[#dc3445] cursor-pointer text-white p-2 mb-3 rounded-lg size-10 top-5 right-5">X</button>

      <div class="w-full">
        <InputLabel for="name" value="Name" />
        <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" required autofocus
          autocomplete="name" />
        <InputError class="mt-2" :message="form.errors.name" />
      </div>

      <div class="mt-2 w-full">
        <InputLabel for="email" value="Email" />
        <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full" required
          autocomplete="username" />
        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <button type="submit" class="w-[80%] m-auto bg-blue-700 text-white rounded-md mt-3 p-3 font-bold text-lg">Editar
        usuario</button>
      <button type="button" @click="emit('closeModal', true)"
        class="w-[80%] m-auto bg-[#dc3445] cursor-pointer text-white p-2 mb-3 rounded-md">Cancelar
        formulario</button>
    </form>
  </section>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import InputLabel from '../InputLabel.vue';
import InputError from '../InputError.vue';
import TextInput from '../TextInput.vue';
import { type User } from '../../types/types.d';


const props = defineProps<{
  user: User
}>()

const emit = defineEmits({
  closeModal: (val: boolean) => val,
  onSubmitForm: (val: string) => val,
})


const form = useForm({
  name: props.user.name,
  email: props.user.email,
});

function submitForm(id: number) {
  form.put(`users/${id}`, {
    preserveScroll: true,
    onSuccess: () => {
      Swal.fire({
        title: 'Usuario editado',
        text: 'El usuario ha sido editado con éxito',
        icon: 'success',
        confirmButtonText: 'Ok'
      });
      // emit('onSubmitForm', 'UserView');
      emit('closeModal', true);
    }
  });
}
</script>
