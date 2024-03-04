<template>
  <div>
    <h1 v-if="$page.props.auth.user" class="text-center text-4xl font-bold my-6 mx-3 md:m-8">Bienvenido {{
      $page.props.auth.user.name }}</h1>
    <div class="bg-gray-200 bg-opacity-25 gap-6 lg:gap-8 p-6 lg:p-8">

      <article class="flex flex-col md:flex-row md:gap-x-2 max-w-screen-md mb-28 mt-4 mx-auto items-center">
        <div>
          <h2 class="text-xl md:text-2xl font-bold mb-2">Semillero de investigacion SUIS</h2>
          <p class="text-sm md:text-xl opacity-80">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptatibus,
            fugit
            delectus dolore eligendi placeat similique minus sed deserunt. Illo, incidunt
            ipsum dolor sit, amet consectetur adipisicing elit. Voluptatibus, fugit
            voluptates alias ex consectetur et ipsum voluptas voluptate voluptatem possimus.
          </p>
          <p class="text-sm md:text-xl opacity-80">Lorem
            delectus dolore eligendi placeat similique minus sed deserunt. Illo, incidunt
            voluptates alias ex consectetur et ipsum voluptas voluptate voluptatem possimus..
          </p>
        </div>
        <img class="rounded-md shadow-md mt-3 md:mt-0" src="/img/carrousel/img/1.png" alt="imagen de sección eventos">
      </article>

      <article class="flex flex-col md:flex-row md:gap-x-8 max-w-screen-md mb-28 mx-auto items-center">
        <img class="rounded-md shadow-md mb-3 md:mb-0" src="/img/carrousel/img/2.png" alt="imagen de sección de noticias">
        <div>
          <h2 class="text-xl md:text-2xl font-bold mb-2">Ultimas Noticias de Semillero de investigacion SUIS</h2>
          <p class="text-sm md:text-xl opacity-80">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptatibus,
            fugit
            delectus dolore eligendi placeat similique minus sed deserunt. Illo, incidunt
            voluptates alias ex consectetur et ipsum voluptas voluptate voluptatem possimus
          </p>
          <p class="text-sm md:text-xl opacity-80">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Voluptatibus,
            fugit
            delectus dolore eligendi placeat similique minus sed deserunt. Illo, incidunt
            voluptates alias ex consectetur et ipsum voluptas voluptate voluptatem possimus..
          </p>
        </div>
      </article>

      <Carousel :slides="slides" :interval="4000" controls indicators />

    </div>
  </div>
</template>

<script setup>
import Carousel from '../Components/Carousel.vue'

const slides = [
  '/img/carrousel/img/aspect-video1.jpeg',
  '/img/carrousel/img/aspect-video2.jpeg',
  '/img/carrousel/img/aspect-video3.jpeg',
  '/img/carrousel/img/aspect-video4.jpeg',
]
</script>
