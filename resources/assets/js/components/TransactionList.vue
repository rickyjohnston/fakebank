<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-9" v-if="transactions.length > 0">
                <h2>Transaction List</h2>
                <table class="table table-light">
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
                            <td v-text="transaction.amount.toFixed(2)"></td>
                            <td v-text="transaction.date"></td>
                        </tr>
                    </tbody>
                </table>
                <paginator class="justify-content-center" :data="paginatorData" v-on:pagination-change-page="getResults"></paginator>
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
                        <option value="">Select an ID</option>
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

                <div class="form-group pt-3">
                    <button class="btn btn-block btn-primary"
                        @click="getResults">
                        Submit
                    </button>
                </div>
                
                <div class="form-group">
                    <button class="btn btn-block btn-outline-danger"
                        @click="clearAndResubmit">
                        Clear and Resubmit
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import Paginator from 'laravel-vue-pagination';

    export default {
        components: {
            Datepicker,
            Paginator
        },

        data() {
            return {
                amount: '',
                customerId: '',
                customers: [],
                date: '',
                page: 1,
                paginatorData: {},
                transactions: []
            }
        },
        
        beforeMount() {
            this.getResults();
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

                return Object.assign({}, amount, date, customerId, { limit: 8, page: this.page });
            }
        },
        
        methods: {
            getResults(page) {
                this.page = (typeof page === 'undefined') ? 1 : page;

                axios.get('/api/transaction', {
                    params: this.filters
                })
                    .then(res => {
                        this.transactions = res.data.data;
                        this.paginatorData = Object.assign({},res.data.links, res.data.meta);
                    })
                    .catch(err => console.error(err));
            },
            
            getCustomerData() {
                axios.post('/api/customers')
                    .then(res => this.customers = res.data)
                    .catch(err => console.error(err));
            },

            clearAndResubmit() {
                this.amount = '';
                this.date = '';
                this.customerId = '';
                this.getResults();
            }
        }
    }
</script>

<style>
    .form-control[name=date] {
        background-color: white;
    }
</style>
