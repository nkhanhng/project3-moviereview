import React, { useEffect, useState } from 'react';
import config from '../../config/config.json'
import axios from 'axios'

const HomeNews = props => {
    const [data,setData] = useState('')
    useEffect(()=>{
        // fetch(`${config.BACKEND_DOMAIN}/api/v1/movie/data?draw=1&start=0&length=10`,{
        //     headers:{
        //         "Content-Type": "application/json"
        //     }
        // })
        // .then(res => {
        //     res.json()
        //     .then((data)=> setData(data.results))
        // })
        axios.get(`${config.BACKEND_DOMAIN}/api/v1/movie/data?draw=1&start=0&length=10`)
            .then(data=>console.log(data))
            .catch(err=> console.log(err))
    })
    console.log(data)
    return(
        <div className="">
            News
        </div>
    )
}

export default HomeNews;