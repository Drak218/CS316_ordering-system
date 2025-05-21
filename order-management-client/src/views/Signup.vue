<template>
  <div class="background">
    <div class="container">
      <div class="header">
        <h1>Sign Up</h1>
      </div>

      <div class="inline">
        <label class="label">Full Name:</label>
        <input
          type="text"
          v-model="fullname"
          placeholder="Enter your full name"
          class="text-box"
        />
      </div>

      <div class="inline">
        <label class="label">Email:</label>
        <input
          type="email"
          v-model="email"
          placeholder="Enter your email"
          class="text-box"
        />
      </div>

      <div class="inline">
        <label class="label">Password:</label>
        <input
          type="password"
          v-model="password"
          placeholder="Enter your password"
          class="text-box"
        />
      </div>

      <div class="button-container">
        <div class="in">
          <button @click="signup" class="button-link">Sign up</button>
        </div>
        <div class="up">
          <router-link to="/SignIn" class="button-link">Login?</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()

const fullname = ref('')
const email = ref('')
const password = ref('')

const signup = async () => {
  try {
    const payload = {
      name: fullname.value,
      email: email.value,
      password: password.value,
    }

      await axios.post('http://127.0.0.1:8000/api/register', payload)
      alert('Signup successful!')
      router.push('/SignIn')
  } catch (error) {
    console.error(error)
    alert('Signup failed: ' + (error.response?.data?.message || error.message))
  }
}
</script>

<style scoped>
.background {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.container {
  background-color: #424874;
  border-radius: 20px;
  border: none;
  padding: 30px;
  width: 90%;
  max-width: 500px;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.header {
  text-align: center;
  color: #f4eeff;
}

.inline {
  display: flex;
  align-items: center;
  gap: 10px;
}

.label {
  width: 120px;
  font-size: 1rem;
  color: #f4eeff;
  flex-shrink: 0;
}

.text-box {
  flex: 1;
  padding: 10px;
  border-radius: 10px;
  border: none;
  background-color: #f4eeff;
  font-size: 1rem;
  color: #424874;
}

.button-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
  margin-top: 10px;
}

.in,
.up {
  width: 100%;
  text-align: center;
  padding: 10px;
  border-radius: 10px;
}

.in {
  background-color: #f4eeff;
}

.up {
  border: 2px solid #f4eeff;
  background-color: #dcd6f7;
}

.button-link {
  text-decoration: none;
  color: #424874;
  font-weight: bold;
  display: block;
  width: 100%;
  background: none;
  border: none;
  cursor: pointer;
  font-size: 1rem;
}
</style>
