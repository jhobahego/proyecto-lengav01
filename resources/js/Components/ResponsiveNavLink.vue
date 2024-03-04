<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    active: Boolean,
    href: String,
    as: String,
});

const classes = computed(() => {
    return props.active
        ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-red-400 text-left text-base font-medium text-white bg-blue-700/60 focus:outline-none focus:text-red-700 focus:bg-blue-800/60 focus:border-red-700 transition duration-150 ease-in-out'
        : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-white hover:text-red-700 hover:bg-blue-500/60 hover:border-red-400 focus:outline-none focus:text-red-700 focus:bg-600/60 focus:border-red-300 transition duration-150 ease-in-out';
});
</script>

<template>
    <div>
        <button v-if="as == 'button'" :class="classes" class="w-full text-left">
            <slot />
        </button>

        <Link v-else :href="href" :class="classes">
        <slot />
        </Link>
    </div>
</template>
