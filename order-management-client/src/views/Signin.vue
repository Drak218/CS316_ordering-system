<template>
  <div class="main">
    <div class="container">
      <div class="header">
        <h1>Login</h1>
      </div>

      <div class="inline">
        <label class="label">Email:</label>
        <input v-model="email" type="text" placeholder="Enter your email" class="text-box" />
      </div>

      <div class="inline">
        <label class="label">Password:</label>
        <input v-model="password" type="password" placeholder="Enter your password" class="text-box" />
      </div>

      <div class="button-container">
        <button @click="handleLogin" class="button in button-link">Sign in</button>
        <router-link to="/" class="button up button-link">Sign up?</router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const email = ref('')
const password = ref('')
const router = useRouter()

const handleLogin = async () => {
  try {
    const response = await axios.post('http://127.0.0.1:8000/api/login', {
      email: email.value,
      password: password.value
    })

    
    const token = response.data.token
    localStorage.setItem('token', token)

    
    router.push('/home')
  } catch (error) {
    alert('Login failed: ' + (error.response?.data?.message || error.message))
  }
}
</script>


<style scoped>

.main {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}


.container {
  display: flex;
  flex-direction: column;
  justify-content: center;
  background-color: #424874;
  border-radius: 20px;
  padding: 50px;
  width: 45%;
  height: 80%;
  box-shadow: 0 0 10px rgba(66, 72, 116, 0.3);
}

.header {
  text-align: center;
  margin-bottom: 20px;
}

h1 {
  color: #DCD6F7;
}

.inline {
  display: flex;
  align-items: center;
  margin-bottom: 15px;
  width: 100%;
  gap: 10px; 
}

.label {
  color: #F4EEFF;
  font-size: 1.2rem;
  width: 100px;
  flex-shrink: 0; 
}

.text-box {
  flex: 1;
  padding: 8px 12px;
  border-radius: 10px;
  border: none;
  background-color: #F4EEFF;
  font-size: 1rem;
  width: 100%; 
}


.button-container {
  margin-top: 20px;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.button {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 40px;
  border-radius: 10px;
}

.in {
  background-color: #DCD6F7;
}

.up {
  background-color: #A6B1E1;
}

.button-link {
  color: #424874;
  text-decoration: none;
  font-weight: bold;
}

input {
  color: #424874;
}
</style>
