<template>
  <AppLayout title="Dashboard">
    <template #header>
      <div class="overflow-hidden h-48 w-full bg-cover flex flex-col items-center justify-center">
        <h1 class="font-bold text-6xl text-[#00447b] leading-tight text-center">
          Panel de administración
        </h1>
        <p class="text-[#00447b] font-medium text-2xl text-center opacity-75">Panel de administración semillero SUIS</p>
      </div>
    </template>

    <div class="py-12 relative">
      <Modal :show="shomModal" :max-width="'lg'" :closeable="true" @close="closeModal">
        <EventForm :title="`Edicion de evento ${selectedEvent?.title}`" :submit-text="'Editar'" :event="selectedEvent"
          @close-modal="closeModal"
          class="edit-form opacity-85 p-10 border border-blue-500 rounded-md flex flex-col items-center gap-y-3" />
      </Modal>
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <aside class="notification d-none align-items-center" id="notifications">
            <svg class="notification-icon" id="notificationIcon" xmlns="http://www.w3.org/2000/svg" width="24"
              height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
              stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"></path>
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

          <div class="grid grid-cols-1 md:grid-cols-3 my-4 m-6 justify-items-center">
            <div class="card mb-14 md:mb-10">
              <h3 class="text-2xl">Gestionar usuarios</h3>
              <img src="/img/admin/gestionarUser.png" alt="Dos manos con usuario">
              <a href="/views/admin/users/manage-users.html"
                class="px-2 py-1 bg-[#00447b] font-bold text-xl text-white rounded-md mt-6" id="manageUserBtn">Click
                aquí</a>
            </div>
            <div class="card mb-14 md:mb-10">
              <h3 class="text-2xl">Gestionar Proyectos</h3>
              <img src="/img/admin/productos.png" alt="Una persona sosteniendo una caja">
              <button class="px-2 py-1 bg-[#00447b] font-bold text-xl text-white rounded-md mt-6">click aquí</button>
            </div>
            <div class="card mb-14 md:mb-10">
              <h3 class="text-xl">Configuraciones del sitio</h3>
              <img src="/img/admin/config.png" alt="Una imagen de un browser con 2 tuercas en el centro">
              <button class="px-2 py-1 bg-[#00447b] font-bold text-xl text-white rounded-md mt-6">Click aquí</button>
            </div>
          </div>

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
import { ref, Ref, onMounted } from 'vue';
import AppLayout from '../../Layouts/AppLayout.vue';
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import Modal from '../../Components/Modal.vue';
import EventForm from '../../Components/EventForm.vue';
import type CalendarOptions from '@fullcalendar/vue3'

import 'v-calendar/style.css';


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
  location: string;
  start: string;
  end?: string;
  duration: string;
  color: string;
}

const props = defineProps({
  events: {
    type: Array as () => Event[],
    required: true,
  },
});

const events: Ref<Event[]> = ref([]);
const selectedEvent = ref<Event>();
const shomModal = ref(false);

const calendarOptions = {
  plugins: [dayGridPlugin, interactionPlugin],
  initialView: 'dayGridMonth',
  dateClick: handleDateClick,
  eventClick: handleEventClick,
  events: props.events,
}

function handleDateClick(info) {
  const dateSelected = new Date(info.dateStr);

  // Formato para input de tipo datetime-locale
  const localeDate = dateSelected.toISOString().slice(0, 16);

  openModal(info);
}

function handleEventClick(info) {
  openModal(info);
}

function openModal(info) {
  shomModal.value = true;
  console.log({ info });

  const event = events.value.find((e) => e.title === info.event.title);
  selectedEvent.value = event;
}

function closeModal(value: boolean) {
  shomModal.value = !value;
}

onMounted(() => {
  events.value = props.events;
  console.log({ eventos: props.events });
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

.card {
  width: 100%;
  max-width: 300px;
  padding: 20px;
  background-color: #f1f1f1;
  border-radius: 6px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

/* Calendario */
.calendar :deep(.vc-container, .vc-pane-container) {
  margin: 30px auto;
}

.edit-form {
  background: linear-gradient(to bottom, rgba(245, 245, 245, 0.5), rgba(26, 108, 141, 0.87));
  /* css aqui */
}

.maxWidthClass {
  max-width: 800px;
}
</style>
