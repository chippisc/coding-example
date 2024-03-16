<template>
    <div class="border border-gray-300 rounded-md py-1.5 relative">
        <input
            placeholder="Tippen, um Nutzer zu suchen"
            name="search"
            id="search"
            v-model="search"
            class="border-none w-full focus:ring-0 px-2 focus:outline-none"
        />
        <ul
            v-if="users && users.length"
            class="absolute top-full divide-y divide-gray-300 w-full mt-2 shadow-md rounded-md border border-gray-300"
        >
            <li v-for="user in users" class="py-2 w-full px-2">
                <a :href="route('users.show', user.id)" class="w-full block">
                    <span v-text="user.full_name"></span>
                </a>
            </li>
        </ul>
    </div>
    <div
        v-if="searchError"
        class="text-xs text-red-500"
        v-text="searchError"
    ></div>
</template>

<script>
import debounce from "lodash.debounce";

export default {
    props: ["url", "csrf"],
    setup(props) {},
    data() {
        return {
            search: "",
            searchError: "",
            users: null,
        };
    },
    watch: {
        search: debounce(function (search) {
            this.fetchUsers(search);
        }, 100),
    },
    methods: {
        fetchUsers(search) {
            if (!this.search) {
                this.users = null;
                this.searchError = null;
                return;
            } else {
                axios
                    .get(this.url, {
                        headers: {
                            accept: "application/json",
                        },
                        params: {
                            search: this.search,
                        },
                        data: {
                            _token: this.csrf,
                        },
                    })
                    .then((response) => {
                        if (response.status === 200) {
                            this.users = response.data;
                            this.searchError = null;
                        }
                    })
                    .catch((error) => {
                        this.searchError = error.response.data.message;
                    });
            }
        },
    },
};
</script>
