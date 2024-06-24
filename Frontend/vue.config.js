const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  transpileDependencies: true
})

module.exports = {
  publicPath: './',
  outputDir: 'public',
  devServer: {
    proxy: 'https://invite-system-backend.up.railway.app'
  }
}
