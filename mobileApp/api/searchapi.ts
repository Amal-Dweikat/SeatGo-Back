import axios from 'axios';

const API = axios.create({
  baseURL: 'http://192.168.1.103:8000/api'
});
const from_city = '';
const to_city = '';
const time = '';

API.get('/search', {
  params: {
    from: from_city,
    to: to_city,
    time: time
  }
});
export default API;