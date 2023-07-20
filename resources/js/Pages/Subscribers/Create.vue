<template>
    <div class="p-10">
        <div class="mb-5 flex justify-between items-center">
            <div class="flex items-center">
                <img src="/logo.png" alt="Logo" class="block h-9 w-auto fill-current" />
                <a href="/">
                    <h1 class="text-lg uppercase font-bold ml-5">Subscribers</h1>
                </a>
                <a href="/fields">
                    <h1 class="text-lg uppercase ml-5">Fields</h1>
                </a>
            </div>
        </div>

        <h1 class="text-xl font-bold mb-5">Add a new subscriber</h1>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group mb-3">
                    <label for="email">Email Address</label>
                    <input type="email" class="form-control" id="email" v-model="email">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" v-model="name">
                </div>
            </div>
            <div class="col-md-3 flex items-center">
                <button @click="createSubscriber" class="btn btn-success px-4 mt-2 font-bold">Add</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: () => ({
        email: '',
        name: ''
    }),
    methods: {
        async createSubscriber() {
            try {
                await axios.post('/api/subscribers', {
                    email: this.email,
                    name: this.name,
                    source: 'web'
                });

                location.href = this.$attrs.ziggy.url;
            } catch (error) {
                alert(error.response.data.message + ' Please try again!');
            }
        }
    }
}
</script>
