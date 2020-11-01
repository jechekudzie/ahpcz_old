<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Laravel Vue Datatables Component Example - Tutsmake.com</div>

                    <div class="card-body">
                        <datatable :columns="columns" :data="rows"></datatable>
                        <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import DatatableFactory from 'vuejs-datatable';

    export default {
        name:'datatable-component',
        components: { DatatableFactory },

        mounted() {
            console.log('Component mounted.')
        },
        data(){
            return {
                columns: [
                    {label: 'id', field: 'id'},
                    {label: 'First Name', field: 'first_name'},
                    {label: 'Last Name', field: 'last_name'},
                ],
                rows: [],
                page: 1,
                per_page: 10,
            }
        },
        methods:{
            getPosts: function() {
                axios.get('/fetchingAllUnit').then(function(response){
                    this.rows = response.data;
                }.bind(this));
            }
        },
        created() {
            this.getPosts()

            Console.log("Created called..")
        }

    }
</script>
