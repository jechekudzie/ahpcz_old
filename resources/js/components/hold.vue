<template>
    <div>
        <div class="col-md-2" id="hide">
            <input type="text"  placeholder="Search" v-model="search"
                   class="form-control form-control-sm">
        </div>
        <table id="practitioners"
               class="display no-wrap table table-hover table-striped table-bordered"
               cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Title</th>
                <th>Practitioner Name</th>
                <th>Registration Number</th>
                <th>Profession</th>
                <th>Professional Qualification</th>
                <th>Accredited Institution</th>
                <th>Status</th>
                <th>view</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="practitioner in practitioners" :key="practitioner.id">
                <td>{{ practitioner.first_name }}</td>
                <td>{{ practitioner.profession.name }}</td>
                <td v-if="practitioner.professional_qualification_id">{{practitioner.professional_qualification.name}}
                </td>
                <td>{{ practitioner.first_name }}</td>
                <td>{{ practitioner.first_name }}</td>
                <td>{{ practitioner.first_name }}</td>
                <td>{{ practitioner.first_name }}</td>
                <td>{{ practitioner.first_name }}</td>
                <td>{{ practitioner.first_name }}</td>
            </tr>
            </tbody>
        </table>
        <div class="col-md-4">
            <pagination :data="practitioners" @pagination-change-page="getResults"></pagination>
        </div>
    </div>

</template>

<script>

    import _ from "lodash";

    export default {

        data() {
            return {
                practitioners: {},
                search: '',
            }
        },
        methods: {

            fetchingAllUnit() {
                /*axios.get('/fetchingAllUnit').then(response => this.practitioners = response.data);*/
                axios.get("/fetchingAllUnit").then(data => (this.practitioners = data.data.data));
            },
            getResults(page = 1) {
                axios.get('/fetchingAllUnit?page=' + page)
                    .then(response => this.practitioners = response.data.data);
            },

            /* searchUnit: _.debounce(function () {
                 axios.get('/search_unit?q=' + this.search)
                     .then((response) => {
                         this.practitioners.data = response.data.practitioner
                     })
             }),*/

        },
        created() {

            this.fetchingAllUnit();

        },

        computed: {
            filteredPractitioners: function () {
                return this.practitioners.filter((practitioner) => {
                    return practitioner.first_name.match(this.search);
                });

            }
        }
    }

</script>

<style scoped>

</style>
