<template>
  <div>
    <h1 v-if="$page.props.auth.user" class="text-center text-4xl font-bold my-6 mx-3 md:m-8">Bienvenido {{
      $page.props.auth.user.name }}</h1>
    <div class="bg-gray-200 bg-opacity-25 gap-6 lg:gap-8 p-6 lg:p-8">

      <article class="flex flex-col md:flex-row md:gap-x-2 max-w-screen-md mb-28 mt-4 mx-auto items-center">
        <div>
          <h2 class="text-xl md:text-2xl font-bold mb-2">Semillero de investigacion SUIS</h2>
          <p class="text-sm md:text-xl opacity-80 mb-2">SUIS es un grupo académico conformado por estudiantes y docentes
            de
            la
            facultad de Ingeniería en Sistemas, dedicado a la investigación y desarrollo de proyectos innovadores en el
            campo de la ingeniería de software, redes de computadoras, inteligencia artificial, entre otros.
          </p>
          <p class="text-sm md:text-xl opacity-80 mb-2">Nuestro semillero se enfoca en promover el desarrollo de
            habilidades
            investigativas en nuestros miembros, fomentando la creatividad y el pensamiento crítico para abordar
            problemas tecnológicos actuales y futuros. Trabajamos en estrecha colaboración con la industria y otras
            instituciones académicas para transferir conocimientos y resultados de investigación que impacten
            positivamente en la sociedad.
          </p>
        </div>
        <img class="rounded-md shadow-md mt-3 md:mt-0" src="/img/carrousel/img/1.png" alt="imagen de sección eventos">
      </article>

      <article class="flex flex-col md:flex-row md:gap-x-8 max-w-screen-md mb-28 mx-auto items-center">
        <img class="rounded-md shadow-md mb-3 md:mb-0" src="/img/carrousel/img/2.png"
          alt="imagen de sección de noticias">
        <div>
          <h2 class="text-xl md:text-2xl font-bold mb-2">Enfocados en mejorar los procesos academicos de la región
            sucreña</h2>
          <p class="text-sm md:text-xl opacity-80">Nuestro semillero está abierto a estudiantes de pregrado y posgrado
            interesados en la investigación en Ingeniería en Sistemas. ¡Únete a nosotros y sé parte del futuro de la
            tecnología!
          </p>
          <p class="text-sm md:text-xl opacity-80">Queremos que la comunidad académica y la sociedad en general conozcan
            los avances y resultados de nuestras investigaciones. Por eso, te invitamos a participar en nuestros eventos
            y a leer nuestras publicaciones.
          </p>
        </div>
      </article>

      <article>
        <h2 class="text-center text-xl md:text-2xl font-bold mb-4">Galería de imagenes sobre encuentros en los que ha participado
          nuestro semillero</h2>
        <Carousel :slides="slides" :interval="4000" controls indicators />
      </article>

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
