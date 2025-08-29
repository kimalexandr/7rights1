<template>
    <div class="form-container">
        <h2>Password Recovery</h2>
        <form @submit.prevent="submit">
            <input type="email" v-model="form.email" placeholder="Enter your email" required/>
            <button type="submit">Send Reset Link</button>
        </form>
        <div v-if="form.errors.email" class="error">
            {{ form.errors.email }}
        </div>

        <div v-if="flashMessage" class="success">
            {{ flashMessage }}
        </div>

    </div>
</template>

<script setup>
import {useForm, usePage} from '@inertiajs/vue3'
import {computed} from "vue";


const form = useForm({email: ''})

const page = usePage()
const flashMessage = computed(() => page.props.flash?.message)

function submit() {
    form.post('/forgot-password', {
        onSuccess: () => {
            form.reset('email')
        }
    })
}
</script>

