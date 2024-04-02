<template>
    <main-content>
        <heading> Infinite Scrolling Liste </heading>
        <div>
            <ul
                class="divide-y divide-gray-300 w-full mt-2 shadow-md rounded-md border border-gray-300 z-50 bg-slate-500 text-white font-bold"
            >
                <li
                    class="py-2 w-full px-2 grid grid-cols-2 gap-6 font-extrabold bg-slate-400"
                >
                    <div
                        class="border border-gray-300 rounded-md py-1.5 relative bg-white text-slate-800 col-span-2 md:col-span-1"
                    >
                        <input
                            id="search"
                            v-model="search"
                            placeholder="Tippen, um Daten zu suchen"
                            name="search"
                            class="border-none w-full focus:ring-0 px-2 focus:outline-none bg-inherit"
                        />
                    </div>
                </li>
                <li
                    class="py-2 w-full px-2 grid grid-cols-2 gap-6 font-extrabold bg-slate-400"
                >
                    <span>Name</span>
                </li>
                <li
                    v-for="user in users ?? []"
                    :key="user.id"
                    class="py-2 w-full px-2 grid grid-cols-2 gap-6"
                >
                    <UserResult :dataset="user" />
                </li>
                <li
                    v-if="users.length == 0 && !loadMore"
                    class="flex gap-2 items-center py-2 px-2 w-full col-span-2"
                >
                    Keine Ergebisse für die Suche <span v-text="search"></span>
                </li>
                <li
                    id="scroll-component"
                    class="flex gap-2 items-center py-2 px-2 w-full col-span-2 cursor-pointer"
                    @click="handleScroll()"
                >
                    <div v-if="loadMore" class="flex space-x-1 items-center">
                        <RefreshIcon
                            class="fill-sky-300"
                            h="20px"
                            w="20px"
                            animate="rotate"
                        />
                        <span>Mehr Ergebnisse werden geladen</span>
                    </div>
                </li>
            </ul>
        </div>
        <div
            v-if="searchError"
            class="text-sm font-bold py-1 text-red-500"
            v-text="searchError"
        ></div>
    </main-content>
</template>

<script>
import debounce from "lodash.debounce";
import UserResult from "../components/UserResult.vue";
import RefreshIcon from "icons/ios-refresh.vue";
import axios from "axios";

export default {
    components: {
        UserResult,
        RefreshIcon,
    },
    data() {
        return {
            search: "",
            searchError: "",
            users: [],
            observer: null,
            offset: 0,
            loadMore: true,
        };
    },
    watch: {
        search: debounce(function () {
            this.loadMore = true;
            this.offset = 0;
            this.searchError = null;
            const newUser = async () => {
                await this.loadMoreUsers().then((newUser) => {
                    this.users = newUser;
                });
            };
            newUser();
        }, 100),
    },
    mounted() {
        let target = document.getElementById("scroll-component");
        this.observer = new IntersectionObserver(this.handleScroll, {
            threshold: 0,
        });
        this.observer.observe(target);
    },
    unmounted() {
        this.observer.disconnect();
    },
    methods: {
        async handleScroll() {
            await this.loadMoreUsers().then((newUser) => {
                this.users.push(...newUser);
            });
        },
        async loadMoreUsers() {
            const newUser = await axios
                .get("/api/users/query", {
                    headers: {
                        accept: "application/json",
                    },
                    params: {
                        search: this.search,
                        amount: 20,
                        offset: this.offset,
                    },
                })
                .then((response) => {
                    if (response.status === 200) {
                        if (response.data.length < 20) {
                            this.loadMore = false;
                        }
                        this.searchError = null;

                        return response.data;
                    }
                })
                .catch((error) => {
                    let status = error.response?.status ?? 500;
                    status === 422
                        ? (this.searchError = error.response.data.message)
                        : (this.searchError =
                              "Die Anfrage konnte nicht verarbeitet werden, bitte probieren Sie es später erneut.");
                });
            this.offset += 20;

            return newUser;
        },
    },
};
</script>
