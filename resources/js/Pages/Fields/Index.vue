<template>
    <div class="p-10">
        <div class="mb-5 flex justify-between items-center">
            <div class="flex items-center">
                <img src="https://btp-assets.s3.eu-west-2.amazonaws.com/logo.png" alt="Logo"
                    class="block h-9 w-auto fill-current" />
                <a href="/">
                    <h1 class="text-lg uppercase ml-5">Subscribers</h1>
                </a>
                <a href="javascript:void(0)">
                    <h1 class="text-lg uppercase font-bold ml-5">Fields</h1>
                </a>
            </div>
            <div><a href="/fields/create" class="btn btn-success font-bold">Add Field</a></div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Type</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(field, index) in fields" :key="field.title">
                        <td>{{ index + 1 }}</td>
                        <td>{{ field.title }}</td>
                        <td>{{ field.type }}</td>
                        <td>
                            <a :href="`/fields/${field.id}`" class="font-bold">Edit</a>
                            <button @click="deleteField(field.id, index)"
                                class="font-bold text-red-500 ml-5">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    data: () => ({
        fields: []
    }),
    async mounted() {
        await this.getFields();
    },
    methods: {
        async getFields() {
            const response = await axios.get('/api/fields');
            this.fields = response.data.data;
        },
        async deleteField(fieldId, index) {
            if (confirm('Are you sure you want to delete?')) {
                await axios.delete(`/api/fields/${fieldId}`);
                this.fields.splice(index, 1);
                setTimeout(() => location.reload(), 2000);
            }
        }
    }
}
</script>
