<template>
  <AppLayout title="Panel de administración">
    <template #header>
      <div class="overflow-hidden h-48 w-full bg-cover flex flex-col items-center justify-center">
        <h1 class="font-bold text-4xl md:text-6xl text-[#00447b] leading-tight text-center mb-2">
          Panel de administración
        </h1>
        <p class="text-[#00447b] font-medium text-xl md:text-3xl text-center opacity-75">Panel de administración
          semillero SUIS</p>
      </div>
    </template>

    <div class="py-12 relative">
      <Modal :show="shomModal" :max-width="'lg'" :closeable="true" @close="closeModal">
        <EditEvent v-if="submitAction === 'editEvent'" :users="props.users" :event="selectedEvent"
          @close-modal="closeModal" @update-item="updateItem" @delete-item="deleteItem"
          class="edit-form opacity-85 p-10 border border-blue-500 rounded-md flex flex-col items-center gap-y-3" />

        <CreateUser v-if="submitAction === 'createUser'" @close-modal="closeModal" />

        <CreateEvent v-if="submitAction === 'createEvent'" :users="props.users" :date-selected="selectedDate"
          @close-modal="closeModal" @add-item="addItem"
          class="edit-form opacity-85 p-10 border border-blue-500 rounded-md flex flex-col items-center gap-y-3" />

      </Modal>
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <aside class="notification d-none align-items-center" id="notifications">
            <svg class="notification-icon" id="notificationIcon" xmlns="http://www.w3.org/2000/svg" width="24"
              height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
              stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6">
              </path>
              <path d="M9 17v1a3 3 0 0 0 6 0v-1"></path><span id="notificationItems"><span
                  data-count-unseen="3"></span></span>
            </svg>
          </aside>
          <header class="flex flex-col items-center">
            <p class="text-xl md:text-2xl text-pretty opacity-75 mt-10 mb-14 mx-auto w-10/12 max-w-screen-md">
              Bienvenido al panel de administración. Aquí puedes gestionar los usuarios, productos y otras
              configuraciones
              del sitio.
            </p>
          </header>

          <div class="grid grid-cols-1 md:grid-cols-3 md:gap-x-4 my-4 m-6 justify-items-center"
            v-if="componentToRender === 'AdminView'">
            <div class="bg-gray-400 rounded-md w-full max-w-72 p-5 flex flex-col items-center mb-14 md:mb-10">
              <h3 class="sm:text-xl md:text-2xl">Gestion de usuarios</h3>
              <img class="h-auto max-w-full" src="/img/admin/gestionarUser.png" alt="Dos manos con usuario">
              <button @click="manageUsers" class="px-2 py-1 bg-[#00447b] font-bold text-xl text-white rounded-md mt-6"
                id="manageUserBtn">Gestionar usuarios</button>
            </div>
            <div class="bg-gray-400 rounded-md w-full max-w-72 p-5 flex flex-col items-center mb-14 md:mb-10">
              <h3 class="sm:text-xl md:text-2xl">Gestion de proyectos</h3>
              <img class="h-auto max-w-full" src="/img/admin/productos.png" alt="Una persona sosteniendo una caja">
              <button @click="manageProjects"
                class="px-2 py-1 bg-[#00447b] font-bold text-xl text-white rounded-md mt-6">Gestionar proyectos</button>
            </div>
            <div class="bg-gray-400 rounded-md w-full max-w-72 p-5 flex flex-col items-center mb-14 md:mb-10">
              <h3 class="sm:text-xl md:text-xl">Configuraciones del sitio</h3>
              <img class="h-auto max-w-full" src="/img/admin/config.png"
                alt="Una imagen de un browser con 2 tuercas en el centro">
              <button @click="siteSettings"
                class="px-2 py-1 bg-[#00447b] font-bold text-xl text-white rounded-md mt-6">Click
                aquí</button>
            </div>
          </div>

          <article v-else-if="componentToRender === 'ProjectView'"
            class="border border-gray-400 p-8 rounded-md flex flex-col m-20">
            <h2 class="text-center text-4xl mb-4 mx-6">Gestionar proyectos</h2>
            <form class="flex flex-col md:flex-row items-center mb-4">
              <label for="search" class="text-base font-semibold mr-8">Buscar proyecto</label>
              <input v-model="searchTerm" type="text" id="search"
                class="w-full p-2 border border-gray-400 rounded-md mb-4 md:mr-6"
                placeholder="Creación aplicativo para mejorar...">

              <label for="filter" class="text-base font-semibold mr-8">Filtrar por tipo de proyecto</label>
              <select id="filter" class="p-2 border border-gray-400 rounded-md mb-4 w-full md:w-auto"
                v-model="filterType">
                <option value="ALL">Todos</option>
                <option value="INVESTIGACIÓN">Investigación</option>
                <option value="EXTENSIÓN">Extensión</option>
                <option value="INNOVACIÓN">Innovación</option>
                <option value="EMPRENDIMIENTO">Emprendimiento</option>
              </select>
            </form>
            <article v-for="project in filteredProjects">
              <Link :href="route('projects.show', project)"
                class="flex items-center justify-between hover:bg-slate-400/75 py-2 border-b border-gray-600/80">
              <h2 class="text-2xl font-semibold mb-2">{{ project.title }}</h2>
              <div class="flex gap-2">
                <p class="text-gray-600">Tipo de proyecto: {{ project.project_type }}</p>
                <p class="text-gray-600">Estado actual: {{ project.project_status }}</p>
              </div>
              </Link>
            </article>
            <button @click="componentToRender = 'AdminView'"
              class="px-3 py-2 bg-[#00447b] font-bold text-xl text-white rounded-md mt-8 self-start mx-auto">Cerrar
              gestion de proyectos</button>
          </article>

          <article v-else-if="componentToRender === 'UserView'"
            class="border border-gray-400 p-8 rounded-md m-4 md:m-20">
            <h2 class="text-center text-4xl mb-4 mx-6">Gestionar usuarios</h2>
            <form class="flex flex-col md:flex-row items-center mb-4">
              <label for="search" class="text-base font-semibold mr-8">Buscar usuario</label>
              <input v-model="searchTerm" type="text" id="search"
                class="w-full p-2 border border-gray-400 rounded-md mb-4 md:mr-6" placeholder="Jhon bairo hernandez...">
            </form>
            <article v-for="user in filteredUsers">
              <div
                class="flex flex-col py-4 md:flex-row items-center justify-between hover:bg-slate-400/75 md:py-2 border-b border-gray-600/80">
                <h2 class="text-xl md:text-2xl font-semibold mb-2">{{ user.name }}</h2>
                <div class="flex flex-col md:flex-row items-center gap-2 justify-between md:justify-normal">
                  <p class="text-gray-600 text-sm md:text-base flex-wrap">Correo: {{ user.email }}</p>
                  <div class="flex items-center gap-x-2">
                    <button @click="editUser(user.id)"
                      class="px-3 py-2 bg-yellow-500 font-semibold md:font-bold text-sm text-white rounded-md self-start">
                      Editar
                    </button>
                    <button @click="deleteUser(user.id)"
                      class="px-3 py-2 bg-[#dc3545] font-semibold md:font-bold text-sm text-white rounded-md self-start">
                      Eliminar
                    </button>
                  </div>
                </div>
              </div>
            </article>

            <div class="flex flex-col md:flex-row items-center md:gap-2 px-4">
              <button @click="componentToRender = 'AdminView'"
                class="px-3 py-2 w-full md:w-auto bg-[#00447b] font-bold text-xl text-white rounded-md mt-8 self-start mx-auto">Cerrar
                gestion de usuarios</button>
              <button @click="submitAction = 'createUser'; shomModal = true; selectedDate = '';"
                class="px-3 py-2 w-full md:w-auto bg-[#00447b] font-bold text-xl text-white rounded-md mt-4 md:mt-8 self-start mx-auto">Agregar
                usuario</button>
            </div>
          </article>

          <section class="text-center mt-12 mb-4">
            <h2 class="text-4xl my-4 mx-6">Proximos eventos</h2>
            <p class="text-2xl opacity-75 mx-6">Calendario con los proximos eventos, click sobre el dia para ver mas
              información</p>

            <article class="m-2 md:m-10">
              <FullCalendar :options="calendarOptions" />
            </article>
          </section>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref, Ref, onMounted, computed } from 'vue';
import AppLayout from '../../Layouts/AppLayout.vue';
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import Modal from '../../Components/Modal.vue';
import EditEvent from '../../Components/Events/EditEvent.vue';
import CreateEvent from '../../Components/Events/CreateEvent.vue';

import { type User, type Event, Project } from '../../types/types.d';
import Swal from 'sweetalert2';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import CreateUser from '@/Components/users/CreateUser.vue';


const props = defineProps<{
  users: User[];
  events: Event[];
  projects: Project[];
}>();

type ComponentName = 'AdminView' | 'UserView' | 'ProjectView' | 'ConfigView';

const events: Ref<Event[]> = ref(props.events);
const selectedEvent = ref<Event>();
const shomModal = ref(false);
const selectedDate = ref('');
const submitAction = ref<'createEvent' | 'editEvent' | 'createUser' | 'createEvent'>('createEvent')

const componentToRender = ref<ComponentName>('AdminView');

let users = computed(() => props.users);

const calendarOptions = {
  plugins: [dayGridPlugin, interactionPlugin],
  initialView: 'dayGridMonth',
  dateClick: handleDateClick,
  eventClick: handleEventClick,
  events: events.value
}

function handleDateClick(info) {
  submitAction.value = 'createEvent';
  selectedDate.value = info.dateStr;
  openModal(info);
}

function handleEventClick(info) {
  submitAction.value = 'editEvent';

  openModal(info);
}
function addItem(event: Event) {
  events.value.push(event);
  Swal.fire('Éxito', 'El evento se ha añadido correctamente', 'success').then(() => {
    window.location.reload();
  });
}

function updateItem(event: Event) {
  const index = events.value.findIndex((e: Event) => e.title === event.title);
  events.value[index] = event;
  Swal.fire('Éxito', 'El evento se ha actualizado correctamente', 'success').then(() => {
    window.location.reload();
  });
}

function deleteItem(id: number) {
  events.value = events.value.filter((e: Event) => e.id !== id);
  Swal.fire('Éxito', 'El evento se ha eliminado correctamente', 'success').then(() => {
    window.location.reload();
  });
}

function openModal(info) {
  shomModal.value = true;

  if (submitAction.value === 'editEvent') {
    const event = events.value.find((e: Event) => e.title === info.event.title);
    selectedEvent.value = event;
  }
}

function closeModal(value: boolean) {
  shomModal.value = !value;
}

function formatDate(dateString: string) {
  if (dateString?.length === 0 || dateString === null) return dateString;

  const date = new Date(dateString);
  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, '0');
  const day = String(date.getDate()).padStart(2, '0');
  const hours = String(date.getHours()).padStart(2, '0');
  const minutes = String(date.getMinutes()).padStart(2, '0');
  const seconds = String(date.getSeconds()).padStart(2, '0');

  return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}

// Manejo de proyectos
function manageProjects() {
  componentToRender.value = 'ProjectView';
}

const filterType = ref('ALL');
const searchTerm = ref('');

const filteredProjects = computed(() => {
  let filtered = props.projects;

  if (searchTerm.value !== '') {
    const term = searchTerm.value.toLowerCase();
    filtered = filtered.filter(project => project.title.toLowerCase().includes(term));
  }

  if (filterType.value !== 'ALL') {
    filtered = filtered.filter(project => project.project_type === filterType.value);
  }

  return filtered;
});

// Manejo de usuarios
function manageUsers() {
  componentToRender.value = 'UserView';
}

const filteredUsers = computed(() => {
  const { user } = usePage().props.auth as unknown as { user: { name: string } };
  let filtered = users.value.filter((u: User) => u.name !== user.name);

  if (searchTerm.value !== '') {
    const term = searchTerm.value.toLowerCase();
    filtered = filtered.filter(user => user.name.toLowerCase().includes(term) || user.email.toLowerCase().includes(term));
  }

  return filtered;
});

function editUser(id: number) {
  alert('TODO: Implementar la edición de usuarios');
  // const userToEdit = users.value.find((u: User) => u.id === id);
  // submitAction.value = 'editUser';
  // shomModal.value = true;
}

function deleteUser(id: number) {
  const userToDelete = users.value.find((u: User) => u.id === id);

  Swal.fire({
    title: '¿Estás seguro?',
    text: 'Esta acción no se puede deshacer',
    icon: 'warning',
    html: `Vas eliminar el usuario <strong>${userToDelete.name}</strong>`,
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      const form = useForm(userToDelete);
      form.delete(`users/${id}`, {
        onFinish: () => {
          Swal.fire('Usuario eliminado', 'El usuario ha sido eliminado correctamente', 'success').then(() => {
            users = computed(() => props.users.filter((u: User) => u.id !== id));
            form.reset();
          })
        }
      });
    }
  });
}

// Manejo de configuraciones del sitio
function siteSettings() {
  alert('Mas adelante se implementará la gestión de configuraciones del sitio');
}

onMounted(() => {
  events.value = props.events.map((event: Event) => {
    event.start = formatDate(event.start);
    event.end = formatDate(event.end);
    return event;
  });
});
</script>

<style scoped>
.banner {
  grid-template-areas: "logo slogan";
  gap: 2em;
}

.logo-remington {
  grid-area: logo;
}

.slogan {
  grid-area: slogan;
  color: #00447b;
  max-width: 90%;
}

.slogan>p {
  color: #00447b;
}

.edit-form {
  background: linear-gradient(to bottom, rgba(245, 245, 245, 0.5), rgba(26, 108, 141, 0.87));
}
</style>
