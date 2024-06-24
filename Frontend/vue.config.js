const { defineConfig } = require('@vue/cli-service');

module.exports = defineConfig({
  transpileDependencies: true,
  publicPath: process.env.NODE_ENV === 'production' ? '/' : '/',
  chainWebpack: config => {
    config.plugin('html').tap(args => {
      args[0].title = 'Event Management System';
      return args;
    });
  },
  devServer: {
    proxy: {
      '/api': {
        target: 'https://invite-system-backend.up.railway.app',
        changeOrigin: true,
        secure: false,
        pathRewrite: { '^/api': '' },
      },
    },
  },
});