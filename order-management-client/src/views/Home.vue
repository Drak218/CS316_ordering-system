<template> 
  <div class="app-wrapper">
    <header class="main-header">
      <h1>Ordering System</h1>
    </header>

    <div class="main-content">
      <!-- LEFT SECTION -->
      <div class="left-section">
        <!-- CUSTOMER SECTION -->
        <section class="form-card">
          <h2>Customer Section</h2>
          <div class="form-group">
            <label>Full Name:</label>
            <input
              type="text"
              v-model="customerName"
              placeholder="ex. Naruto Uzumaki"
              ref="fullNameInput"
            />
          </div>
          <div class="form-group">
            <label>Address:</label>
            <input type="text" v-model="address" placeholder="Street + Barangay" />
          </div>
          <div class="form-group">
            <label>City:</label>
            <select v-model="selectedCity">
              <option disabled value="">-- select an option --</option>
              <option>Calamba</option>
              <option>Binan</option>
              <option>Los Banos</option>
              <option>Sta. Rosa</option>
              <option>Cabuyao</option>
            </select>
          </div>
          <div class="form-group">
            <label>Zip Code:</label>
            <input type="text" v-model="zipCode" placeholder="ex. 4027"/>
          </div>
          <div class="form-group">
            <label>Staff ID:</label>
            <input type="text" v-model="staffId" placeholder="ex. 1" />
          </div>
        </section>

        <!-- PRODUCT SECTION -->
        <section class="form-card">
          <h2>Product Section</h2>
          <div class="form-group">
            <label>Product Name:</label>
            <input type="text" v-model="productName" />
          </div>
          <div class="form-group">
            <label>Price:</label>
            <input type="number" v-model.number="price" />
          </div>
          <div class="form-group">
            <label>Quantity:</label>
            <input type="number" v-model.number="quantity" />
          </div>
          <div class="form-group">
            <label>Weight (lbs):</label>
            <input type="number" v-model.number="weight" />
          </div>
        </section>

        <!-- SHIPPING SECTION -->
        <section class="form-card">
          <h2>Shipping Section</h2>
          <div class="form-group">
            <label>Shipping Option:</label>
            <select v-model="shippingMethod">
              <option value="">-- Select an option --</option>
              <option value="UPS">UPS</option>
              <option value="FedEx">FedEx</option>
              <option value="Ninjavan">Ninjavan</option>
            </select>
          </div>
        </section>

        <!-- Buttons -->
        <div class="button-row">
          <button class="action-btn" @click="submitOrder">Submit Order</button>
          <button class="action-btn" @click="clearForm" style="background-color: #FF4D4D">Clear</button>
           <button class="action-btn" @click="goToDisplay" style="background-color: #4DA6FF">View Orders</button>
        </div>
      </div>

      <!-- RIGHT SECTION -->
      <div class="right-section">
        <section class="form-card">
          <h2>Computation Section</h2>
          <div class="form-group">
            <label>Item Cost:</label>
            <output>{{ itemCost.toFixed(2) }}</output>
          </div>
          <div class="form-group">
            <label>Sales Tax (10%):</label>
            <output>{{ salesTax.toFixed(2) }}</output>
          </div>
          <div class="form-group">
            <label>Shipping Fee:</label>
            <output>{{ shippingFee.toFixed(2) }}</output>
          </div>
          <div class="form-group">
            <label>Handling Fee:</label>
            <output>{{ handlingFee.toFixed(2) }}</output>
          </div>
          <div class="form-group">
            <label>Total:</label>
            <output>{{ total.toFixed(2) }}</output>
          </div>
        </section>
        <button class="logout-btn" @click="logout">Logout →</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, nextTick } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'


const router = useRouter()

const fullNameInput = ref(null)

// Form Fields
const customerName = ref('')
const address = ref('')
const selectedCity = ref('')
const zipCode = ref('')
const staffId = ref('')
const productName = ref('')
const price = ref(0)
const quantity = ref(0)
const weight = ref(0)
const shippingMethod = ref('')
const taxExempt = ref(false)

// Computed Values
const itemCost = computed(() => price.value * quantity.value)
const salesTax = computed(() => taxExempt.value ? 0 : itemCost.value * 0.1)

// Shipping fee based on weight and shipping method
const shippingFee = computed(() => {
  if (!shippingMethod.value || weight.value <= 0) return 0

  switch (shippingMethod.value) {
    case 'UPS':
      return 5 + 2 * weight.value
    case 'FedEx':
      return 4 + 2.5 * weight.value
    case 'Ninjavan':
      return 3 + 1.5 * weight.value
    default:
      return 0
  }
})

// Handling fee = ₱4.75 × quantity + ₱0.10 × quantity × weight
const handlingFee = computed(() => {
  return 4.75 * quantity.value + 0.10 * quantity.value * weight.value
})

const total = computed(() => itemCost.value + salesTax.value + shippingFee.value + handlingFee.value)

// Submit order function
const submitOrder = async () => {
  try {
    const payload = {
      staff_id: staffId.value,
      customer_name: customerName.value,
      address: address.value,
      city: selectedCity.value,
      zip_code: zipCode.value,
      tax_exempt: taxExempt.value,
      product_name: productName.value,
      price: price.value,
      quantity: quantity.value,
      weight: weight.value,
      shipping_method: shippingMethod.value,
      sales_tax: salesTax.value,
      shipping_fee: shippingFee.value,
      handling_fee: handlingFee.value,
      total: total.value
    }

    await axios.post('http://localhost:8000/api/orders', payload)
    alert('Order submitted successfully!')
  } catch (error) {
    console.error(error)
    alert('Order submission failed: ' + (error.response?.data?.message || error.message))
  }
}

// Clear form function
const clearForm = () => {
  customerName.value = ''
  address.value = ''
  selectedCity.value = ''
  zipCode.value = ''
  staffId.value = ''
  productName.value = ''
  price.value = 0
  quantity.value = 0
  weight.value = 0
  shippingMethod.value = ''
  taxExempt.value = false

  nextTick(() => {
    fullNameInput.value?.focus()
  })
}

// Logout function
const logout = () => {
  // Clear user session or tokens from localStorage or cookies
  localStorage.removeItem('authToken')
  localStorage.removeItem('userData')

  // Redirect to login page (change '/login' to your actual login route)
  router.push('/SignIn')
  }

  const goToDisplay = () => {
  router.push('/display') // or the route name, e.g., router.push({ name: 'Display' })
}
</script>

<style scoped>
.app-wrapper {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  width: 100%;
}

.main-header {
  margin-top: 5px;
  text-align: center;
  color: #F4EEFF;
  font-size: 1.5rem;
}

.main-content {
  display: flex;
  flex-wrap: wrap;
  flex: 1;
  padding: 1rem;
  gap: 2rem;
  margin: 2rem;
  width: 100%;
}

.left-section,
.right-section {
  flex: 1 1 48%;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.form-card {
  background-color: #424874;
  border: 4px solid #DCD6F7;
  border-radius: 12px;
  padding: 1rem;
  color: #F4EEFF;
}

h1 {
  color: #424874;
}

h2 {
  margin-top: 0;
  font-size: 1.25rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  margin-bottom: 0.75rem;
}

.form-group label {
  margin-bottom: 0.3rem;
  font-weight: bold;
}

.form-group input,
.form-group select,
.form-group output {
  padding: 0.5rem;
  border-radius: 8px;
  border: none;
  background-color: #DCD6F7;
  color: #424874;
  font-size: 1rem;
}

.button-row {
  display: flex;
  gap: 1rem;
  justify-content: flex-start;
}

.action-btn {
  background-color: #424874;
  color: white;
  padding: 0.6rem 1.2rem;
  border: none;
  border-radius: 8px;
  font-weight: bold;
  cursor: pointer;
}

.logout-btn {
  align-self: flex-end;
  margin-bottom: 1rem;
  background-color: #FF4D4D;
  color: white;
  border: none;
  padding: 0.6rem 1rem;
  border-radius: 8px;
  cursor: pointer;
}

@media (max-width: 768px) {
  .left-section,
  .right-section {
    flex: 1 1 100%;
  }
}

.action-btn,
.logout-btn {
  opacity: 1;
  transition: opacity 0.2s ease;
}

.action-btn:hover,
.logout-btn:hover {
  opacity: 1;
}

</style>
