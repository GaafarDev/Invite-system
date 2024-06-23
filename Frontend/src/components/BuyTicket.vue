<template>
  <div class="buy-ticket-popout">
    <div class="buy-ticket-header">
      <h2>Select Tickets</h2>
      <button @click="$emit('close')" class="close-button" aria-label="Close">X</button>
    </div>
    <div class="ticket-list-container">
      <div class="list-header">
        <span><u>Ticket Type</u> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Quantity</u></span>
      </div>
      <div class="ticket-list">
        <div v-for="ticket in tickets" :key="ticket.id" class="ticket-item">
          <div class="ticket-info">
            <p>{{ ticket.ticket_name }}</p>
            <p>RM {{ ticket.ticket_price }}</p>
          </div>
          <div class="ticket-quantity">
            <button aria-label="Decrease quantity" @click="decreaseQuantity(ticket.id)">-</button>
            <input type="number" v-model.number="ticket.quantity" min="0" readonly>
            <button aria-label="Increase quantity" @click="increaseQuantity(ticket.id)">+</button>
          </div>
        </div>
      </div>
    </div>
    <div class="summary">
      <p>QTY: {{ totalQuantity }} | Total: RM {{ totalCost }}</p>
      <button @click="handlePurchase">Proceed ></button>
    </div>
  </div>
</template>

<script>
import apiClient from '../services/api.js';

export default {
  props: {
    tickets: Array
  },
  computed: {
    totalCost() {
      return this.tickets.reduce((sum, ticket) => sum + (ticket.quantity * ticket.ticket_price), 0);
    },
    totalQuantity() {
      return this.tickets.reduce((sum, ticket) => sum + ticket.quantity, 0);
    }
  },
  methods: {
    async handlePurchase() {
  try {
    let allPurchasesSuccessful = true;
    for (const ticket of this.tickets) {
      if (ticket.quantity > 0) {
        const payload = {
          user_id: 1, // This should be dynamically set based on the logged-in user
          ticket_id: ticket.id,
          quantity: ticket.quantity,
        };

        console.log('Payload sent:', JSON.stringify(payload, null, 2));
        const response = await apiClient.post(`/api/ticketsales`, payload);
        console.log('Purchase successful for ticket ID', ticket.id, response.data);
      }
    }
    if (allPurchasesSuccessful) {
      // Optionally handle success, e.g., show a success message
      alert('Purchase successful!');
      this.$emit('close'); // Close the popout
    }
    // Optionally handle success, e.g., show a success message
  } catch (error) {
    console.error('Purchase failed', error);
    // Optionally handle error, e.g., show an error message to the user
  }
},
    increaseQuantity(ticketId) {
      const ticket = this.tickets.find(t => t.id === ticketId);
      ticket.quantity++;
    },
    decreaseQuantity(ticketId) {
      const ticket = this.tickets.find(t => t.id === ticketId);
      if (ticket.quantity > 0) {
        ticket.quantity--;
      }
    }
  }
};
</script>


<style scoped>
.buy-ticket-popout {
  position: fixed;
  top: 20%;
  left: 50%;
  transform: translateX(-50%);
  background: white;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  width: 500px;
  padding: 20px;
  z-index: 1000;
}

.buy-ticket-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
}

.ticket-list {
  max-height: 400px;
  overflow-y: auto;
  margin-bottom: 20px;
}

.ticket-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.ticket-info {
  flex: 1;
}

.ticket-quantity {
  display: flex;
  align-items: center;
}

.ticket-quantity button {
  width: 30px;
  height: 30px;
  border-radius: 50%;
  border: 1px solid black;
}

.ticket-quantity input {
  width: 50px;
  text-align: center;
  margin: 0 10px;
  border: none;
}

.summary {
  text-align: center;
}

.summary button {
  background-color: #2B293D;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
}

.list-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.close-button {
  background-color: transparent;
  border: none;
  cursor: pointer;
  font-size: 20px;
  position: absolute;
  top: 10px;
  right: 10px;
}
</style>