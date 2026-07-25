import { defineConfig } from 'vite';
import { resolve } from 'path';

export default defineConfig({
  root: '.',
  publicDir: 'public',
  build: {
    outDir: 'dist',
    rollupOptions: {
      input: {
        main: resolve(__dirname, 'index.html'),
        rooms: resolve(__dirname, 'pages/rooms.html'),
        roomDetail: resolve(__dirname, 'pages/room-detail.html'),
        booking: resolve(__dirname, 'pages/booking.html'),
        payment: resolve(__dirname, 'pages/payment.html'),
        bookingSuccess: resolve(__dirname, 'pages/booking-success.html'),
        dashboard: resolve(__dirname, 'pages/dashboard.html'),
        admin: resolve(__dirname, 'pages/admin.html'),
      },
    },
  },
  server: {
    port: 3000,
    open: true,
  },
});
