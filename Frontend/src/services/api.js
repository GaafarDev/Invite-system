

// Add a request interceptor

export default apiClient;
apiClient.interceptors.request.use(
  config => {
    const token = localStorage.getItem('token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  error => {
    return Promise.reject(error);
  }
);
import axios from 'axios';

axios.defaults.withCredentials = true;

const apiClient = axios.create({
  baseURL: 'http://127.0.0.1:8000',  // Ensure this matches your Laravel server URL
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  }
});