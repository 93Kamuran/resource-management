import axios from 'axios'

const axiosClient = axios.create({
        baseURL: `http://localhost:8000`,
        withCredentials: false,
        headers: {
            Accept: 'application/json',
            'Content-Type': 'application/json'
        },
        timeout: 10000
    }
)
export default axiosClient
