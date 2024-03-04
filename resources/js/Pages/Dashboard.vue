<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Index from '@/Components/Index.vue';
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <div class="banner overflow-hidden h-52 md:h-64 w-full bg-cover flex flex-col sm:grid sm:justify-between items-center">
        <img src="/img/logo-remington.png" alt="SUIS" class="logo-remington h-auto min-w-20 sm:max-w-full" />
        <div class="slogan">
          <h2 class="text-xl text-center sm:text-2xl mb-2 md:text-4xl font-bold">SUIS</h2>
          <p class="text-md text-center sm:text-xl md:text-2xl text-white font-medium text-pretty">Investigando no para la escuela, sino para la
            vida</p>
        </div>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <Index />
        </div>
      </div>
    </div>
  </AppLayout>
</template>

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
</style>
