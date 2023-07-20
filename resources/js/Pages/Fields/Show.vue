<template>
    <div class="p-10">
        <div class="mb-5 flex justify-between items-center">
            <div class="flex items-center">
                <img src="https://btp-assets.s3.eu-west-2.amazonaws.com/logo.png" alt="Logo"
                    class="block h-9 w-auto fill-current" />
                <a href="/">
                    <h1 class="text-lg uppercase ml-5">Subscribers</h1>
                </a>
                <a href="/fields">
                    <h1 class="text-lg uppercase font-bold ml-5">Fields</h1>
                </a>
            </div>
        </div>

        <h1 class="text-xl font-bold mb-5">Update a shared field</h1>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group mb-3">
                    <label>Title</label>
                    <input type="text" class="form-control" v-model="fieldTitle">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Type</label>
                    <select class="form-control" v-model="fieldType">
                        <option>string</option>
                        <option>number</option>
                        <option>boolean</option>
                        <option>date</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3 flex items-center">
                <button @click="updateField" class="btn btn-success px-4 mt-2 font-bold">Update</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['id'],
    data: () => ({
        fieldTitle: '',
        fieldType: ''
    }),
    async mounted() {
        await this.getFieldResource();
    },
    methods: {
        async getFieldResource() {
            const response = await axios.get(`/api/fields/${this.id}`);
            this.fieldTitle = response.data.data.title;
            this.fieldType = response.data.data.type;
        },
        async updateField() {
            await axios.patch(`/api/fields/${this.id}`, {
                title: this.fieldTitle,
                type: this.fieldType
            });
            location.href = this.$attrs.ziggy.url + '/fields';
        }
    }
}
</script>
