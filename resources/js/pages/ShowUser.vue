<template>
    <main-content>
        <heading> Nutzer </heading>

        <div class="pb-6 grid grid-cols-2 gap-3">
            <div class="font-bold">Name:</div>
            <div v-text="user.full_name"></div>
            <div class="font-bold">Nutzername:</div>
            <div v-text="user.username"></div>
            <hr class="col-span-2" />
        </div>
        <a class="text-sky-300 font-bold cursor-pointer" @click="goBack()"
            >Zurück</a
        >

        <div
            v-if="error"
            class="text-sm font-bold py-1 text-red-500"
            v-text="error"
        ></div>
    </main-content>
</template>

<script>
import axios from "axios";
import { route } from "ziggy-js";
import router from "../router";

export default {
    props: {
        userId: {
            type: String,
            default: null,
        },
    },
    data() {
        return {
            user: [],
            error: null,
        };
    },
    mounted() {
        this.getUser();
    },
    methods: {
        goBack() {
            router.go(-1);
        },
        async getUser() {
            const user = await axios
                .get(route("users.show", [this.userId]), {
                    headers: {
                        accept: "application/json",
                    },
                })
                .then((response) => {
                    if (response.status === 200) {
                        if (response.data.length < 20) {
                            this.loadMore = false;
                        }
                        this.error = null;

                        return response.data;
                    }
                })
                .catch(() => {
                    this.error = "Der Nutzer wurde nicht gefunden.";
                });

            this.user = user;
        },
    },
};
</script>
