<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Index from '../Components/Index.vue';

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
});

</script>

<template>
  <Head title="SUIS" />
  <div
    class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-center selection:bg-red-500 selection:text-white">
    <nav class="nav-bg sm:fixed sm:top-0 sm:right-0 sm:left-0 p-8">
      <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
        <template v-if="$page.props.auth.user !== undefined">
          <Link :href="route('login')"
            class="font-semibold text-white hover:text-red-700 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
          Log in</Link>

          <Link v-if="canRegister" :href="route('register')"
            class="ml-4 font-semibold text-white hover:text-red-700 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
          Register</Link>
        </template>
      </div>
    </nav>

    <div class="max-w-7xl mx-auto p-6 lg:p-8 mt-14">
      <Index />
    </div>
  </div>
</template>

<style>
.nav-bg {
  background-color: #00447b;
}
</style>
