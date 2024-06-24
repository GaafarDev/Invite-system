import axios from 'axios';

const apiClient = axios.create({
  baseURL: 'https://invite-system-backend.up.railway.app/api',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  }
});

export default apiClient;
