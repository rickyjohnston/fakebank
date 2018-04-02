<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                <h2>Transaction List</h2>

                <div class="">
                    <div class="form-group">
                        <label for="customerId">
                            Customer ID
                        </label>
                        <select class="form-control" name="customerId" id="customerId" v-model="customerId">
                            <option v-for="customer in customers" :key="customer">
                                {{ customer }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="amount">
                            Amount
                        </label>
                        <input class="form-control" id="amount" name="amount" type="text" v-model="amount">
                    </div>

                    <div class="form-group">
                        <label for="date">
                            Date
                        </label>
                        <input class="form-control" type="text" id="date" name="date" v-model="date">
                    </div>

                    <div class="form-group">
                        <button class="btn btn-block btn-primary"
                            @click="getFilteredSearch">
                            Submit
                        </button>
                    </div>
                </div>

                <div class="card-body" v-if="transactions.length > 0">
                    <table class="table" style="width: 100%">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Customer ID</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="transaction in transactions" :key="transaction.transactionId">
                                <td v-text="transaction.customerId"></td>
                                <td v-text="transaction.amount"></td>
                                <td v-text="transaction.date"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-body" v-else>
                    No transactions found. 😃
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                amount: '',
                customerId: '',
                customers: [],
                date: '',
                searchUrl: '/api/transaction',
                transactions: []
            }
        },
        beforeMount() {
            this.loadInitialData();
            this.getCustomerData();
        },
        computed: {
            filters() {
                let amount = (this.amount) ? { amount: this.amount } : {};
                let date = (this.date) ? { date: this.date } : {};
                let customerId = (this.customerId) ? { customerId: this.customerId } : {};

                return Object.assign({}, amount, date, customerId, { limit: 10 });
            }
        },
        methods: {
            loadInitialData() {
                axios.get(this.searchUrl, {
                    params: {
                        limit: 10
                    }
                })
                    .then(res => {
                        this.transactions = res.data.data;
                        // this.searchUrl = res.data.links.next;
                    })
                    .catch(err => console.error(err));
            },
            getCustomerData() {
                axios.post('/api/customers')
                    .then(res => this.customers = res.data)
                    .catch(err => console.error(err));
            },
            getFilteredSearch() {
                axios.get(this.searchUrl, {
                    params: this.filters
                })
                    .then(res => this.transactions = res.data.data)
                    .catch(err => console.error(err));
            }
        }
    }
</script>
