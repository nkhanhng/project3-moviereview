import axios from 'axios';

export default axios.create({
  baseURL: 'https://api.themoviedb.org/3',
  headers: {
    "Access-Control-Allow-Origin": "*",
    "Content-Type": "application/json",
  }
})