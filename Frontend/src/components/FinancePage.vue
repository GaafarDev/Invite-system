<template>
  <div class="finance-page">
    <ProfitLabel :profit="parseFloat(calculateTotalProfit())" />

    <h2>My Events List</h2>

    <div class="events-list">
      <div v-for="event in events" :key="event.id" class="event-card">
        <h3>{{ event.title }}</h3>
        <div>
          <table>
            <thead>
              <tr>
                <th>Ticket Name</th>
                <th>Ticket Price</th>
                <th>Quantity Sold</th>
                <th>Total Sales</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="ticket in event.tickets" :key="ticket.id">
                <td>{{ ticket.ticket_name }}</td>
                <td>RM {{ ticket.ticket_price }}</td>
                <td>{{ getQuantitySold(ticket.id) }}</td>
                <td>RM {{ calculateTotalSales(ticket) }}</td>
              </tr>
            </tbody>
          </table>
          <p><strong>Total: RM {{ calculateEventTotal(event) }}</strong></p>
        </div>
      </div>
    </div>

   <!-- <div class="profit-chart-container">
      <canvas ref="profitChart"></canvas>
    </div>-->
  </div>
</template>

<script>
import ProfitLabel from './ProfitLabel.vue';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

export default {
  components: {
    ProfitLabel
  },
  data() {
    return {
      userId: 1, // Replace with actual user ID
      events: [],
      ticketSales: {}, // Store ticket sales by ticket ID with quantities and total sales
      profitChart: null,
    };
  },
  mounted() {
    this.fetchEvents();
  },
  methods: {
    fetchEvents() {
      const url = `http://127.0.0.1:8000/api/users/${this.userId}/createdevents`;
      fetch(url)
        .then(response => response.json())
        .then(data => {
          this.events = data;
          this.fetchTicketSales(); // Fetch ticket sales data after events are loaded
          this.renderProfitChart(); // Render the profit chart
        })
        .catch(error => {
          console.error('Error fetching events:', error);
        });
    },
    fetchTicketSales() {
      this.events.forEach(event => {
        event.tickets.forEach(ticket => {
          const url = `http://127.0.0.1:8000/api/ticketsales/ticket/${ticket.id}`;
          fetch(url)
            .then(response => response.json())
            .then(data => {
              // Calculate total sales for each ticket including quantity
              const totalSales = data.reduce((total, sale) => {
                return total + (sale.quantity * ticket.ticket_price);
              }, 0);
              // Store total sales and quantities for the ticket
              this.$setTicketSales(ticket.id, {
                totalSales: parseFloat(totalSales.toFixed(2)), // Convert to number and fix to 2 decimal places
                quantitySold: this.calculateQuantitySold(data),
              });
            })
            .catch(error => {
              console.error('Error fetching ticket sales:', error);
            });
        });
      });
    },
    $setTicketSales(ticketId, salesData) {
      this.ticketSales = {
        ...this.ticketSales,
        [ticketId]: salesData,
      };
    },
    calculateQuantitySold(ticketSalesData) {
      return ticketSalesData.reduce((total, sale) => {
        return total + sale.quantity;
      }, 0);
    },
    getQuantitySold(ticketId) {
      return this.ticketSales[ticketId] ? this.ticketSales[ticketId].quantitySold : 0;
    },
    calculateTotalSales(ticket) {
      const totalSales = this.ticketSales[ticket.id] ? this.ticketSales[ticket.id].totalSales : 0;
      return totalSales.toFixed(2); // Ensure total sales is formatted to 2 decimal places
    },
    calculateEventTotal(event) {
      return event.tickets.reduce((total, ticket) => {
        return total + parseFloat(this.ticketSales[ticket.id] ? this.ticketSales[ticket.id].totalSales : 0);
      }, 0).toFixed(2); // Ensure event total is formatted to 2 decimal places
    },
    calculateTotalProfit() {
      return this.events.reduce((total, event) => {
        return total + parseFloat(this.calculateEventTotal(event));
      }, 0).toFixed(2); // Ensure total profit is formatted to 2 decimal places
    },
    renderProfitChart() {
      // Prepare data for the chart
      const chartData = this.prepareChartData();

      // Use Chart.js to render the chart
      const ctx = this.$refs.profitChart.getContext('2d');
      this.profitChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: chartData.labels,
          datasets: [
            {
              label: 'Monthly Profit',
              data: chartData.data,
              fill: false,
              borderColor: '#2196F3',
              tension: 0.1,
            },
          ],
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'top',
            },
            tooltip: {
              mode: 'index',
              intersect: false,
            },
          },
          scales: {
            x: {
              display: true,
              title: {
                display: true,
                text: 'Month',
              },
            },
            y: {
              display: true,
              title: {
                display: true,
                text: 'Profit (RM)',
              },
            },
          },
        },
      });

      // Log total profit for each month to the console
      chartData.monthlyProfits.forEach((profit, index) => {
        console.log(`${chartData.labels[index]}: RM ${profit}`);
      });
    },
    prepareChartData() {
  const currentDate = new Date();
  const sixMonthsAgo = new Date(currentDate.getFullYear(), currentDate.getMonth() - 6, 1);
  const twelveMonthsLater = new Date(currentDate.getFullYear(), currentDate.getMonth() + 6, 1);

  // Initialize profits for each month
  const monthlyProfits = Array(12).fill(0);

  this.events.forEach(event => {
    console.log('Event:', event); // Log the entire event object
    const eventDate = new Date(event.start_datetime);
    if (eventDate >= sixMonthsAgo && eventDate < twelveMonthsLater) {
      const monthIndex = eventDate.getMonth() - sixMonthsAgo.getMonth() + (eventDate.getFullYear() - sixMonthsAgo.getFullYear()) * 12;
      if (event.tickets) {
        event.tickets.forEach(ticket => {
          console.log('Ticket:', ticket); // Log the ticket object
          const ticketSales = this.ticketSales[ticket.id];
          if (ticketSales) {
            console.log('Ticket Sales:', ticketSales); // Log the ticket sales object
            // Add the profit for this ticket to the corresponding month
            monthlyProfits[monthIndex] += ticketSales.totalSales;
          }
        });
      }
    }
  });

  // Prepare labels (month names)
  const labels = [];
  for (let i = 0; i < 12; i++) {
    const date = new Date(sixMonthsAgo.getFullYear(), sixMonthsAgo.getMonth() + i, 1);
    labels.push(date.toLocaleString('default', { month: 'long' }) + ' ' + date.getFullYear());
  }

  return {
    labels: labels,
    data: monthlyProfits.map(profit => parseFloat(profit.toFixed(2))),
  };
},
  },
};
</script>

<style scoped>
.finance-page {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 20px; /* Add margin-top to create space from the navbar */
}

.events-list {
  width: 70%;
  margin-top: 20px;
}

.event-card {
  background-color: #fff;
  border-radius: 12px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  padding: 16px;
  margin-bottom: 20px;
}

h2, h3 {
  margin-top: 20px;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
}

th, td {
  border: 1px solid #ddd;
  padding: 8px;
}

th {
  background-color: #f2f2f2;
}

.profit-chart-container {
  margin-top: 20px;
  width: 70%;
}
</style>