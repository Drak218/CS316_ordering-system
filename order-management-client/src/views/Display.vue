<template>
  <div class="p-4 flex flex-col items-center justify-center min-h-screen background">
    <h1 class="text-2xl font-semibold mb-6">ORDERS</h1>

    <input
      v-model="searchQuery"
      type="text"
      placeholder="Search by customer name..."
      class="mb-6 p-2 border border-gray-300 rounded w-72 max-w-full search-bar"
    />

    <div class="overflow-x-auto w-full max-w-4xl">
      <table class="orders-table mx-auto">
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Customer Name</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>City</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="order in filteredOrders" :key="order.id">
            <td>{{ order.id }}</td>
            <td>{{ order.customer_name }}</td>
            <td>{{ order.product_name }}</td>
            <td>{{ order.quantity }}</td>
            <td>{{ order.city }}</td>
            <td>₱{{ parseFloat(order.total).toFixed(2) }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-if="filteredOrders.length === 0" class="mt-4 text-gray-500">
      No matching orders found.
    </div>
    <br>
    <button @click="downloadPDF" class="mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 download">
      Download PDF
    </button>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import jsPDF from 'jspdf'
import 'jspdf-autotable'

const orders = ref([])
const searchQuery = ref('')

// Fetch orders from backend
const fetchOrders = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/orders')
    orders.value = response.data
  } catch (error) {
    console.error('Error fetching orders:', error)
  }
}

onMounted(fetchOrders)

const filteredOrders = computed(() => {
  return orders.value.filter(order =>
    order.customer_name.toLowerCase().includes(searchQuery.value.toLowerCase())
  )
})

const downloadPDF = () => {
  const doc = new jsPDF()

  const columns = [
    { header: 'Order ID', dataKey: 'id' },
    { header: 'Customer Name', dataKey: 'customer_name' },
    { header: 'Product', dataKey: 'product_name' },
    { header: 'Quantity', dataKey: 'quantity' },
    { header: 'City', dataKey: 'city' },
    { header: 'Total', dataKey: 'total' },
  ]

  const rows = filteredOrders.value.map(order => ({
    id: order.id,
    customer_name: order.customer_name,
    product_name: order.product_name,
    quantity: order.quantity,
    city: order.city,
    total: `₱${parseFloat(order.total).toFixed(2)}`
  }))

  doc.autoTable({
    columns,
    body: rows,
    margin: { top: 20 },
    styles: { halign: 'center' },
    headStyles: { fillColor: [166, 177, 225] }
  })

  doc.text('Orders List', 14, 15)
  doc.save('orders.pdf')
}
</script>

<style scoped>
.search-bar{
    margin: 2%;
    height:5vh;
    width: 40%;
}
.download {
  background-color: #2563eb; /* Tailwind bg-blue-600 */
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
}
.background {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 100vh; /* full viewport height for vertical centering */
  padding: 1rem;
  box-sizing: border-box;
}

.orders-table {
  width: 100%;
  border-collapse: collapse;
  background-color: #F4EEFF;
  color: #424874;
  font-size: 0.95rem;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
  max-width: 100%; /* prevent overflow */
}

.orders-table th,
.orders-table td {
  border: 1px solid #DCD6F7;
  padding: 0.75rem 1rem;
  text-align: center;
}

.orders-table th {
  background-color: #A6B1E1;
  color: white;
}

@media (max-width: 768px) {
  .orders-table {
    font-size: 0.85rem;
  }
}
</style>
