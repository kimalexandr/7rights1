<template>
    <div class="form-container">
        <h2>Reset Password</h2>
        <form @submit.prevent="submit">
            <input type="hidden" v-model="form.token" />

            <p v-if="form.errors.token" class="error">{{ form.errors.token }}</p>

            <div>
                <input type="email" v-model="form.email" placeholder="Enter your email" required />
                <p v-if="form.errors.email" class="error">{{ form.errors.email }}</p>
            </div>

            <div>
                <input type="password" v-model="form.password" placeholder="New Password" required />
                <p v-if="form.errors.password" class="error">{{ form.errors.password }}</p>
            </div>

            <div>
                <input type="password" v-model="form.password_confirmation" placeholder="Confirm Password" required />
                <p v-if="form.errors.password_confirmation" class="error">{{ form.errors.password_confirmation }}</p>
            </div>

            <button type="submit" :disabled="form.processing">Reset Password</button>
        </form>

        <p v-if="flashMessage" class="success">{{ flashMessage }}</p>
    </div>
</template>


<script setup>
import {useForm, usePage} from '@inertiajs/vue3'
import {computed} from "vue";

const props = defineProps({ token: String })
const page = usePage()
const flashMessage = computed(() => page.props.flash?.message)

const form = useForm({
    token: props.token,
    email: '',
    password: '',
    password_confirmation: ''
})

function submit() {
    form.post('/reset-password')
}
</script>
