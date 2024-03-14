<template>
  <section class="max-w-5xl mx-auto mt-10">
    <header>
      <h1 class="text-4xl font-bold text-center">Creación de usuarios</h1>
    </header>
    <form @submit.prevent="submitForm" class="form-projects rounded-lg flex flex-col items-center p-7">
      <div class="w-full">
        <InputLabel for="role" value="Selecciona tu profesión" />
        <select id="role" v-model="form.role"
          class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
          required>
          <option value="STUDENT">Estudiante</option>
          <option value="TEACHER">Profesor</option>
          <option value="MANAGER">Gestor</option>
        </select>
        <InputError class="mt-2" :message="form.errors.role" />
      </div>

      <div class="mt-4 w-full">
        <InputLabel for="name" value="Name" />
        <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" required autofocus
          autocomplete="name" />
        <InputError class="mt-2" :message="form.errors.name" />
      </div>

      <div class="mt-4 w-full">
        <InputLabel for="email" value="Email" />
        <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full" required
          autocomplete="username" />
        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div class="mt-4 w-full">
        <InputLabel for="password" value="Password" />
        <TextInput id="password" v-model="form.password" type="password" class="mt-1 block w-full" required
          autocomplete="new-password" />
        <InputError class="mt-2" :message="form.errors.password" />
      </div>

      <div class="mt-4 w-full">
        <InputLabel for="password_confirmation" value="Confirm Password" />
        <TextInput id="password_confirmation" v-model="form.password_confirmation" type="password"
          class="mt-1 block w-full" required autocomplete="new-password" />
        <InputError class="mt-2" :message="form.errors.password_confirmation" />
      </div>

      <button type="submit" class="bg-blue-700 text-white rounded-md p-3 font-bold text-lg">Crear usuario</button>
      <button type="button" @click="emit('closeModal', true)"
        class="bg-[#dc3445] cursor-pointer text-white p-2 mb-3 rounded-md">Cancelar
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


const emit = defineEmits({
  closeModal: (val: boolean) => val,
  onSubmitForm: (val: string) => val,
})

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  role: 'STUDENT',
});

function submitForm() {
  if (form.password !== form.password_confirmation) {
    Swal.fire({
      title: 'Error',
      text: 'Las contraseñas no coinciden',
      icon: 'error',
      confirmButtonText: 'Ok'
    });
    return;
  }

  form.post('users', {
    preserveScroll: true,
    onSuccess: () => {
      Swal.fire({
        title: 'Usuario creado',
        text: 'El usuario ha sido creado con éxito',
        icon: 'success',
        confirmButtonText: 'Ok'
      });
      // emit('onSubmitForm', 'UserView');
      emit('closeModal', true);
    },
    onError: (errors) => {
      Swal.fire({
        title: 'Error',
        text: 'Ha ocurrido un error al crear el usuario',
        icon: 'error',
        confirmButtonText: 'Ok'
      });
      console.log(errors);
    }
  });
}

</script>

<style scoped>
.form-projects {
  width: 90%;
  margin: 20px auto;
  gap: 14px;
  border: 1px solid #09f;
  background: linear-gradient(to bottom, rgba(245, 245, 245, 0.5), rgba(26, 108, 141, 0.87));
}

.form-projects>button {
  width: 80%;
  margin: 0 auto;
}
</style>