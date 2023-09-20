<template>
    <AppLayout title="Stores">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Stores
            </h2>
        </template>

        <template #alert v-if="successMessage">
            <div class="relative bg-green-100 border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md"
                role="alert" @click="successMessage = ''">
                <strong class="font-bold">Success! &nbsp;</strong>
                <span class="block sm:inline"> {{ successMessage }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                    <Icon name="close" class="w-6 h-6 m-auto fill-gray-400" />
                </span>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="flex justify-between m-3">
                        <TextInput id="email" v-model="form.search" type="email" class="mt-1 block w-1/3" required
                            placeholder="Search" autocomplete="off" />

                        <Link
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            :href="route('user-store.create')">
                        <span>New&nbsp;</span>
                        <span class="hidden md:inline">Store</span>
                        </Link>

                    </div>

                    <table class="w-full my-2 whitespace-no-wrap bg-white">
                        <tr class="font-bold text-left">
                            <th class="p-4">#</th>
                            <th class="p-4">Name</th>
                            <th class="p-4">Description</th>
                            <th class="p-4">Location</th>
                            <th class="p-4 text-center">Action</th>
                        </tr>

                        <tr v-for="(row, i) of stores.data" :key="row.id"
                            class="border-t hover:bg-gray-100 focus-within:bg-gray-100">

                            <td class="p-3">
                                {{ row.id }}
                            </td>

                            <td class="p-3">
                                {{ row.name }}
                            </td>

                            <td class="p-3">
                                {{ row.description }}
                            </td>

                            <td class="p-3">
                                {{ row.location }}
                            </td>

                            <td class="p-3">
                                <div class="flex place-content-center">
                                    <div class="grid mr-4">
                                        <Link class="focus:text-indigo-500" :href="route('user-store.edit', row.id)">
                                        <Icon name="pencil" class="w-6 h-6 m-auto fill-gray-400" />
                                        </Link>
                                    </div>
                                    <div class="grid">
                                        <inertia-link style="cursor:pointer;" class="focus:text-indigo-500"
                                            @click="confirmDelete(row.id)">
                                            <icon name="trash" class="w-6 h-6 m-auto" />
                                        </inertia-link>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <div class="flex justify-end m-3">
                        <Paginate :links="stores.links" />

                    </div>

                </div>
            </div>
        </div>

        <DialogModal :show="confirmingDeletion" @close="closeModal">
            <template #title>
                Delete Store
            </template>

            <template #content>
                Are you sure you want to delete this store? Please enter the word "DELETE" to confirm you would like to
                delete this store.

                <div class="mt-4">
                    <TextInput v-model="confirmMessage" type="text" class="mt-1 block w-3/4" autocomplete="off"
                        @keyup.enter="deleteUser" />
                    <p class="text-sm text-red-600">
                        {{ errors.confirmMessage }}
                    </p>
                </div>
            </template>

            <template #footer>
                <SecondaryButton @click="closeModal">
                    Cancel
                </SecondaryButton>

                <DangerButton class="ml-3" :class="{ 'opacity-25': processing }" :disabled="processing" @click="deleteUser">
                    Delete Store
                </DangerButton>
            </template>
        </DialogModal>
    </AppLayout>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import Paginate from '@/Components/Pagination.vue';
import Icon from '@/Components/Icon.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import throttle from "lodash/throttle";

export default {
    components: {
        AppLayout,
        Icon,
        Link,
        TextInput,
        PrimaryButton,
        DialogModal,
        DangerButton,
        SecondaryButton,
        Paginate

    },
    props: {
        success: { type: String },
        stores: {
            type: Object,
            default: () => { },
        },
        filters: { type: [Object, Array], default: () => { } },
    },
    data() {
        return {
            successMessage: null,
            form: {
                search: '',
            },
            errors: [],
            selectedId: '',
            confirmingDeletion: false,
            confirmMessage: '',
            processing: false
        };
    },
    watch: {
        form: {
            handler: throttle(function () {
                this.$inertia.replace(this.route("user-store.index", this.form));
            }, 250),
            deep: true,
        },
    },
    mounted() {
        console.log(this.$page.props)
    },
    methods: {
        confirmDelete(id) {
            this.confirmingDeletion = true;
            this.selectedId = id
        },

        deleteUser() {
            if (this.confirmMessage === "DELETE") {
                const self = this;
                this.$inertia.delete(this.route("user-store.destroy", self.selectedId), {
                    preserveScroll: true,
                    onSuccess: (data) => {
                        this.confirmingDeletion = false
                        this.confirmMessage = '';
                        this.successMessage = "Successfully delete store"
                    },
                    onError: (errors) => {
                        self.errors = errors
                        console.log(self.errors)
                    }
                })
            } else {
                this.errors.confirmMessage = "Please make sure you type 'DELETE' on the input box"
            }

        },

        closeModal() {
            this.confirmingDeletion = false
        }

    },
}
</script>