<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Transaction List</div>

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
                                <tr v-for="transaction in transactions">
                                    <td v-text="transaction.customerId"></td>
                                    <td v-text="transaction.amount"></td>
                                    <td v-text="transaction.date"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body" v-else>
                        No data.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                transactions: []
            }
        },
        beforeMount() {
            axios.get('/api/transaction')
                .then(res => this.transactions = res.data.data)
                .catch(err => console.error(err));
        }
    }
</script>
