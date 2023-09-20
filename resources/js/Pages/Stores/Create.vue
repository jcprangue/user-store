<template>
  <AppLayout title="Stores">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <Link 
            class="text-indigo-400 hover:text-indigo-600"
            :href="route('user-store.index')">
            User Stores
        </Link>
        <span class="font-medium">/</span>
        Create New
      </h2>
    </template>

    <div class="py-12">
      <div class="w-full sm:max-w-xl mx-auto  px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <form @submit.prevent="submit">
          <div class="mt-4">
              <InputLabel for="name" value="Name" />
              <TextInput
                  id="name"
                  v-model="form.name"
                  type="text"
                  class="mt-1 block w-full"
                  autocomplete="off"
              />
              <p class="text-sm text-red-600">
                  {{ errors.name }}
              </p>
          </div>

          <div class="mt-4">
              <InputLabel for="description" value="Description" />
              <TextInput
                  id="description"
                  v-model="form.description"
                  type="text"
                  class="mt-1 block w-full"
                  autocomplete="off"
              />
              <p class="text-sm text-red-600">
                  {{ errors.description }}
              </p>
          </div>

            <div class="mt-4">
                <InputLabel for="location" value="Location" />
                <TextInput
                    id="location"
                    v-model="form.location"
                    type="text"
                    class="mt-1 block w-full"
                    autocomplete="off"
                />
                <p class="text-sm text-red-600">
                    {{ errors.location }}
                </p>
            </div>

          
          <div class="flex items-center justify-end mt-4">
            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </PrimaryButton>
          </div>
        </form>
      </div>
    </div>

  </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Icon from '@/Components/Icon.vue';
import LoadingButton from "@/Components/LoadingButton.vue";
import { Head, Link } from '@inertiajs/vue3';

export default {
  components: {
    AppLayout,
    Icon,
    Link,
    LoadingButton,
    TextInput,
    InputLabel,
    InputError,
    PrimaryButton
  },
  data() {
    return {
      form: {
        name: '',
        description: '',
        location: '',
      },
      errors:[]
    };
  },
  methods: {
    submit() {
      const self = this;
        this.$inertia.post(this.route("user-store.store"), this.form, {
          preserveScroll: true,
          onError: (errors) => {
            self.errors = errors
            console.log(self.errors)
          }
        })
    }
  },
}
</script>