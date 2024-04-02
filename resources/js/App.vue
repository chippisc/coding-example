<template>
    <router-view v-slot="{ Component, route }">
        <div :key="route.name" class="min-h-screen flex flex-col bg-white">
            <div class="flex-1">
                <nav-bar></nav-bar>
                <Component :is="Component" />
            </div>
        </div>
    </router-view>
</template>

<script>
import NavBar from "./components/NavBar.vue";

export default {
    components: {
        NavBar,
    },
};
</script>
