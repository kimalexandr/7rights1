<template>
    <div class="form-container">
        <h2>Login</h2>

        <p v-if="flashMessage" class="success">{{ flashMessage }}</p>

        <form @submit.prevent="submit">
            <div class="form-group">
                <input
                    type="email"
                    v-model="form.email"
                    placeholder="Email"
                    required
                />
                <p v-if="form.errors.email" class="error">{{ form.errors.email }}</p>
            </div>

            <div class="form-group">
                <input
                    type="password"
                    v-model="form.password"
                    placeholder="Password"
                    required
                />
                <p v-if="form.errors.password" class="error">{{ form.errors.password }}</p>
            </div>

            <button type="submit" :disabled="form.processing">
                {{ form.processing ? 'Logging in...' : 'Login' }}
            </button>
        </form>

        <p class="forgot-password">
            <a href="/forgot-password">Forgot Password?</a>
        </p>
    </div>
</template>

<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const page = usePage();
const flashMessage = computed(() => page.props.flash?.message);

const form = useForm({
    email: "",
    password: "",
});

function submit() {
    form.post("/login");
}
</script>

<style scoped>
.form-container {
    max-width: 400px;
    margin: 50px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #fff;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
}

input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
}

button {
    width: 100%;
    padding: 10px;
    background: #4f46e5;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

button:disabled {
    background: #a5b4fc;
    cursor: not-allowed;
}

.error {
    color: red;
    font-size: 0.9em;
    margin-top: 4px;
}

.success {
    color: green;
    text-align: center;
    margin-bottom: 10px;
}

.forgot-password {
    text-decoration: underline;
    margin-top: 10px;
}
</style>
