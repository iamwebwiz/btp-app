<template>
    <div class="p-10">
        <div class="mb-5 flex justify-between items-center">
            <div class="flex items-center">
                <img src="/logo.png" alt="Logo" class="block h-9 w-auto fill-current" />
                <a href="/"><h1 class="text-lg uppercase font-bold ml-5">Subscribers</h1></a>
                <a href="/fields"><h1 class="text-lg uppercase ml-5">Fields</h1></a>
            </div>
        </div>

        <div class="mb-5">
            <h1 class="text-xl font-bold mb-5">Edit Subscriber</h1>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group mb-3">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" disabled v-model="subscriber.email">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" v-model="subscriber.name">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="state">State</label>
                        <select id="state" class="form-control" v-model="subscriber.state">
                            <option>active</option>
                            <option>unsubscribed</option>
                            <option>junk</option>
                            <option>bounced</option>
                            <option>unconfirmed</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 flex items-center">
                    <button @click="updateSubscriber" class="btn btn-success font-bold px-4 mt-2">Update</button>
                </div>
            </div>
        </div>

        <!-- Subscriber fields -->
        <div>
            <h2 class="text-lg font-bold mb-5">Add fields to subscriber</h2>
            <div class="row mb-5">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="field">Field</label>
                        <select id="field" class="form-control" ref="fieldToAdd">
                            <option value="">Select field</option>
                            <option :value="field.id" v-for="field in fields" :key="field.title">{{ field.title }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-secondary font-bold mt-4" @click="addField">Add field</button>
                </div>
            </div>
            <div class="row mb-3" v-for="(field, index) in subscriberFields" :key="field.field_id">
                <div class="col-md-3 capitalize">
                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" class="form-control capitalize" disabled :value="field.title">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Value</label>
                        <input type="text" class="form-control" v-model="field.value" v-if="field.type == 'string'">
                        <input type="number" class="form-control" v-model="field.value" v-else-if="field.type == 'number'">
                        <input type="date" class="form-control" v-model="field.value" v-else-if="field.type == 'date'">
                        <input type="checkbox" class="form-control" v-model="field.value" v-else>
                    </div>
                </div>
                <div class="col-md-3"><button class="btn btn-danger font-bold mt-4" @click="removeSubscriberField(index)">Remove</button></div>
            </div>
            <button class="btn btn-success font-bold" @click="saveFields">Save fields</button>
        </div>
    </div>
</template>

<script>
export default {
    props: ['id'],
    data: () => ({
        subscriber: {},
        fields: [],
        subscriberFields: []
    }),
    async mounted() {
        await this.getSubscriber();
        await this.getFields();
    },
    methods: {
        async getSubscriber() {
            const response = await axios.get(`/api/subscribers/${this.id}`);
            this.subscriber = response.data.data;
            if (!! response.data.data.fields) {
                response.data.data.fields.forEach((field) => {
                    this.subscriberFields.push({
                        field_id: field.id,
                        title: field.title,
                        type: field.type,
                        value: field.pivot.value
                    });
                });
            }
        },
        async getFields() {
            const response = await axios.get('/api/fields');
            this.fields = response.data.data;
        },
        async updateSubscriber() {
            await axios.patch(`/api/subscribers/${this.id}`, {
                name: this.subscriber.name,
                state: this.subscriber.state,
            });
            location.href = this.$attrs.ziggy.url;
        },
        addField() {
            const index = this.fields.findIndex(field => field.id == this.$refs.fieldToAdd.value);
            this.subscriberFields.push({
                field_id: this.fields[index].id,
                title: this.fields[index].title,
                type: this.fields[index].type,
                value: ''
            });
        },
        removeSubscriberField(index) {
            this.subscriberFields.splice(index, 1);
        },
        async saveFields() {
            const response = await axios.post(`/api/subscribers/${this.id}/fields`, {
                fields: this.subscriberFields
            });
            alert(response.data.message);
        }
    }
}
</script>
