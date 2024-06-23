<template>
  <div class="profit-card">
    <div class="profit-icon">💵</div>
    <div class="profit-info">
      <div class="profit-label">Profit</div>
      <div class="profit-value">{{ currencySymbol }}{{ profit.toLocaleString() }}</div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    profit: {
      type: Number,
      required: true
    },
    currencySymbol: {
      type: String,
      default: 'RM'
    }
  }
}
</script>

<style scoped>
.profit-card {
  display: flex;
  align-items: center;
  background-color: #fff;
  border-radius: 12px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  padding: 16px;
  max-width: 300px;
}

.profit-icon {
  font-size: 24px;
  margin-right: 12px;
  color: #4CAF50;
}

.profit-info {
  display: flex;
  flex-direction: column;
}

.profit-label {
  font-size: 16px;
  color: #888;
}

.profit-value {
  font-size: 24px;
  font-weight: bold;
  color: #333;
}
</style>
