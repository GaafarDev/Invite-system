<template>
    <div class="mb-4">
      <label :for="id" class="block text-gray-700 text-sm font-bold mb-2">{{ label }}</label>
      <input
        :id="id"
        :type="type"
        :placeholder="placeholder"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        v-model="inputValue"
        @input="$emit('update:modelValue', inputValue)"
      />
    </div>
  </template>
  
  <script>
  export default {
    name: 'TextField',
    props: {
      id: String,
      label: String,
      type: {
        type: String,
        default: 'text'
      },
      placeholder: String,
      modelValue: String
    },
    data() {
      return {
        inputValue: this.modelValue
      };
    }
  };
  </script>
  
  <style scoped>
  /* No additional CSS needed as Tailwind handles the styling */
  </style>
  