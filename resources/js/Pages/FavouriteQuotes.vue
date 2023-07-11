<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card-header">
                <Link href="/home">Quotes</Link>
                <Link href="/favourites">Favourites</Link>
            </div>
            <h3 class="text-center">Favourite Quotes</h3>
            <div class="col-md-8">
                <p v-show="loading">loading...</p>
                <div
                    v-show="!loading"
                    class="card"
                    v-for="(quote, index) in favouriteQuotes"
                    :key="index"
                >
                    <div class="card-body row">
                        <div class="col-md-10">
                            {{ quote.quote }}
                        </div>
                        <button
                            type="button"
                            class="btn btn-primary float-end col-md-2"
                            @click="removeFromFavourites(quote.id)"
                        >
                            Remove from Favourites
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3";
import axios from "axios";

export default {
    components: {
        Link,
    },
    props: {
        data: String,
    },
    data() {
        return {
            favouriteQuotes: null,
            loading: true,
        };
    },
    methods: {
        removeFromFavourites(quoteId) {
            axios
                .delete(`/delete-favourite-quote/${quoteId}`)
                .then((res) => {
                    if (res.status === 200) {
                        this.favouriteQuotes = this.favouriteQuotes.filter(
                            (quote) => quote.id !== quoteId
                        );
                    }
                })
                .catch((error) => console.error(error));
        },
    },
    mounted() {
        this.favouriteQuotes = JSON.parse(this.data);
        this.loading = false;
    },
};
</script>
