<template>
    <div class="p-10">
        <div class="mb-5 flex justify-between items-center">
            <div class="flex items-center">
                <img src="https://btp-assets.s3.eu-west-2.amazonaws.com/logo.png" alt="Logo"
                    class="block h-9 w-auto fill-current" />
                <a href="javascript:void(0)">
                    <h1 class="text-lg uppercase font-bold ml-5">Subscribers</h1>
                </a>
                <a href="/fields">
                    <h1 class="text-lg uppercase ml-5">Fields</h1>
                </a>
            </div>
            <div><a href="/subscribers/create" class="btn btn-success font-bold">Add Subscriber</a></div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Source</th>
                        <th scope="col">State</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(subscriber, index) in subscribers" :key="subscriber.email">
                        <td>{{ index + 1 }}</td>
                        <td>{{ subscriber.name }}</td>
                        <td>{{ subscriber.email }}</td>
                        <td>{{ subscriber.source }}</td>
                        <td>
                            <span :class="`badge rounded-pill text-bg-${statePillMap[subscriber.state]}`">
                                {{ subscriber.state }}
                            </span>
                        </td>
                        <td>
                            <a :href="`/subscribers/${subscriber.id}`" class="font-bold">Edit</a>
                            <button @click="deleteSubscriber(subscriber.id, index)"
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
        subscribers: [],
        statePillMap: {
            'active': 'success',
            'junk': 'danger',
            'bounced': 'info',
            'unconfirmed': 'warning',
            'unsubscribed': 'secondary'
        },
    }),
    async mounted() {
        await this.getSubscribers();
    },
    methods: {
        async getSubscribers() {
            const response = await axios.get('/api/subscribers');
            this.subscribers = response.data.data;
        },
        async deleteSubscriber(subscriberId, index) {
            if (confirm('Are you sure you want to delete?')) {
                await axios.delete(`/api/subscribers/${subscriberId}`);
                this.subscribers.splice(index, 1);
                setTimeout(() => location.reload(), 2000);
            }
        }
    }
}
</script>
