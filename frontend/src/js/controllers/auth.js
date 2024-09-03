// gere l'authentication

import axiosInstance from '../utils/axiosInstance';

export function login(email, password) {
    return axiosInstance.post('/login', {email, password})
}

export const register = async (FormData) => {
    alert(1111111)
    try {
        const response = await axiosInstance.post('/register', FormData, {
            headers: {
                'Content-Type': 'multipart/form-data'
              }
        })
        console.log('Inscription reussie: ', response.data)
    } catch (error) {
        console.log('Erreur lors de l\'inscription', error)
        //retourner une erreur ou un message d'erreur
        throw error
    }
}

export function logout() {
    return axiosInstance.post('/logout')
}