import axios from 'axios';

axios.defaults.withCredentials = true;

const apiClient = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL,  // Use the environment variable
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  }
});

// Add a request interceptor
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

export default apiClient;
