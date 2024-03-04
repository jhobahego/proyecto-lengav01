<template>
  <AppLayout title="Noticias">
    <template #header>
      <div class="overflow-hidden h-48 w-full bg-cover flex flex-col items-center justify-center">
        <h1 class="font-bold text-6xl text-[#00447b] leading-tight text-center">
          Noticias
        </h1>
        <p class="text-[#00447b] font-medium text-2xl text-center opacity-75">Vea las noticias mas destacadas acerca del
          semillero SUIS</p>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <!-- <h1 class="text-4xl text-center font-semibold mt-10 mb-5">Noticias destacadas</h1> -->
          <ul class="grid grid-cols-1 md:grid-cols-2 gap-2 justify-items-center" v-if="news.length > 0">
            <li v-for="item in news" :key="item.id"
              class="card border border-blue-500 rounded-md m-3 p-3 max-w-80 flex flex-col">
              <h3 class="text-4xl font-bold text-center mb-2">{{ item.title }}</h3>
              <p class="text-1xl opacity-80 font-semibold mb-3">{{ item.description }}</p>
              <a :href="item.url" target="_blank"
                class="p-2 font-bold bg-blue-700 text-white rounded-md self-start mt-auto">Visitar</a>
            </li>
          </ul>
          <div v-else class="text-center p-10">
            <h1 class="text-3xl font-semibold mb-4">No hay noticias disponibles</h1>
            <p class="text-xl font-semibold opacity-70">Por favor, vuelva mas tarde</p>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import { ref, onMounted, Ref } from 'vue';
import AppLayout from '../Layouts/AppLayout.vue';

interface News {
  id: number;
  autor: string;
  title: string;
  description: string;
  event_id: number;
  url: string;
}

const news: Ref<News[]> = ref([]);

const props = defineProps({
  news: {
    type: Array<News>,
    required: true,
  },
});

onMounted(() => {
  news.value = props.news;
});
</script>

<style scoped>
.card {
  background: linear-gradient(to bottom, rgba(245, 245, 245, 0.5), rgba(26, 108, 141, 0.87));
}
</style>