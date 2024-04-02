<template>
    <div>
        <div
            class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full bg-blue-600 text-white justify-between font-bold px-2"
        >
            <div class="flex gap-2 items-center">
                <router-link
                    active-class="cursor-default underline"
                    class="p-3"
                    to="/"
                    >Typeahead Suche</router-link
                >
                <router-link
                    active-class="cursor-default underline"
                    class="p-3"
                    to="/users"
                    >Infinite Scroll</router-link
                >
            </div>
        </div>
    </div>
</template>
