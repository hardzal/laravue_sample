<template>
    <div class="contaner my-5">
        <div class="row justify-content-center">
            <div class="col-8">
                <router-link :to="{ name: 'transaction.create' }"
                    class="btn btn-primary btn-sm rounded shadow mb-3"
                >Create</router-link>

                <div class="card rounded shadow">
                    <div class="card-header">
                        Transaction  List
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(transaction, index) in transactions.data" :key="index">
                                    <td>{{ transaction.title }}</td>
                                    <td>{{ transaction.amount }}</td>
                                    <td>{{ transaction.type }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <router-link :to="{ name: 'transaction.edit', params: { id: transaction.index} }" class="btn btn-sm btn-outline-info">edit</router-link>
                                            <button class="btn btn-sm btn-outline-danger">delete</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import { onMounted, ref } from 'vue'
export default {
    setup() {
        // reactive state
        let transactions = ref([]);

        onMounted(() => {
            // get data from endpoint
            axios.get('http://localhost:8000/api/transactions')
            .then((result) => { 
                transactions.value = result.data
            })
            .catch((err) => {
                console.log(err.response)
            });
        });

        return {
            transactions
        }
    }
}
</script>