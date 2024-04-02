<template>
    <router-link :to="{ name: 'showUser', params: { userId: dataset.id } }">
        <span v-text="dataset.full_name"> </span>
    </router-link>
</template>

<script>
export default {
    props: {
        dataset: Object({}),
    },
};
</script>
