<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card-header">
                <Link href="/">Quotes</Link>
                <Link href="/favourites">Favourites</Link>
            </div>

            <button @click="getNewQuotes">Refresh</button>

            <h3 class="text-center">All Quotes</h3>
            <div class="col-md-8">
                <p v-show="loading">Loading...</p>
                <div
                    v-show="!loading"
                    class="card"
                    v-for="(quote, index) in quotes"
                    :key="index"
                >
                    <div class="card-body row">
                        <div class="col-md-10">
                            {{ quote.quote }}
                        </div>
                        <button
                            type="button"
                            class="btn btn-primary float-end col-md-2"
                            @click="addToFavourite(quote.quote)"
                            :disabled="quote.disabled"
                        >
                            Add to Favourites
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
            loading: true,
            quotes: null,
        };
    },
    methods: {
        getNewQuotes() {
            this.loading = true;
            axios
                .get("/quotes")
                .then(({ data }) => {
                    this.quotes = data;
                    this.loading = false;
                })
                .catch((error) => console.error(error));
        },
        addToFavourite(quote) {
            axios
                .post("/add-to-favourites", {
                    quote,
                })
                .then((res) => {
                    let { status, data } = res;
                    if (res && status === 200) {
                        this.quotes = this.quotes.map((quote) => {
                            if (data.data === quote.quote) {
                                quote.disabled = true;
                            }
                            return quote;
                        });
                    }
                });
        },
        getFavourites() {
            return axios.get("/get-favorites-quotes");
        },
    },
    mounted() {
        this.quotes = JSON.parse(this.data).map((quote) => {
            quote.disabled = false;
            return quote;
        });

        this.getFavourites().then((res) => {
            const favourites = res.data;
            this.quotes = this.quotes.map((quote) => {
                const matched = favourites.find((favouriteQuote) => {
                    return quote.quote === favouriteQuote.quote;
                });

                if (matched) {
                    quote.disabled = true;
                }

                return quote;
            });
        });

        this.loading = false;
    },
};
</script>
