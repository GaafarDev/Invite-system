module.exports = {
  content: [
    './index.html',
    './src/**/*.{vue,js,ts,jsx,tsx}',
  ],
  theme: {
    extend: {
      fontFamily: {
        'sans': ['Open Sans', 'sans-serif'],
        'montserrat': ['Montserrat', 'sans-serif'],
      },
      colors: {
        'custom-heading': '#2D2C3C',
        'custom-bg': '#2B293D',
        'custom-button': '#2B293D',
      },
    },
  },
  plugins: [],
}
