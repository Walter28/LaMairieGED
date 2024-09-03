import axios from 'axios'
import { error } from 'console'

const axiosInstance = axios.create({
    baseURL : 'http://127.0.0.1:8000/api',
    headers: {
        'Content-Type' : 'application/json'
    }
})

// Ajout des interceptors pour gerer les tokens d'authentications
axiosInstance.interceptors.request.use((config) => {
    const token = localStorage.getItem('token')

    if (token) {
        config.headers['Authorization'] = `Bearer ${token}`
    }

    return config;
}, (error) => {
    return Promise.reject(error)
})

export default axiosInstance