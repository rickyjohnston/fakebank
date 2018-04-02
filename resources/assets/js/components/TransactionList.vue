<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-9" v-if="transactions.length > 0">
                <h2>Transaction List</h2>
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
            <div class="col-9" v-else>
                No transactions found. 😃
            </div>
            <div class="col">
                <h2>Filters</h2>
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
                    <datepicker input-class="form-control" format="yyyy-MM-dd" v-model="date" name="date" id="date"></datepicker>
                </div>

                <div class="form-group">
                    <button class="btn btn-block btn-primary"
                        @click="getFilteredSearch">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    export default {
        components: {
            Datepicker
        },
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
            day() {
                return this.date.getDate();
            },
            month() {
                return this.date.getMonth() + 1;
            },
            year() {
                return this.date.getFullYear();
            },
            filters() {
                let amount = (this.amount) ? { amount: this.amount } : {};
                let date = (this.date) ? { date: `${this.year}-${this.month}-${this.day}` } : {};
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

<style>
    .form-control[name=date] {
        background-color: white;
    }
</style>
