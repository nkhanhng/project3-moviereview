import React, { useEffect, useState } from 'react';
import config from '../../config/config.json';
import axios from 'axios';
import { Link } from 'react-router-dom';


const News = props => {
    const [data, setData] = useState('')
    const [showModal, setShowModal] = useState(false)
    useEffect(() => {
        // fetch(`${config.BACKEND_DOMAIN}/api/v1/movie/data?draw=1&start=0&length=10`,{
        //     headers:{
        //         "Content-Type": "application/json"
        //     }
        // })
        // .then(res => {
        //     res.json()
        //     .then((data)=> setData(data.results))
        // })
        axios.get(`${config.BACKEND_DOMAIN}/api/v1/post/data?draw=1&start=0&length=10`)
            .then(data => setData(data.data))
            .catch(err => console.log(err))
    }, [])

    const renderNews = (data1) => {
        if (data1) {
            const newsList = data1.data.map((news) => {
                return (
                    <div key={news.id} className="card" 
                        style={{ width: '960px', margin: "auto", marginBottom: "20px" }} 
                        onClick={() => setShowModal(true)}
                    >
                        <Link to={{
                            pathname: `/news/${news.id}`,
                            state: {
                                title: news.title,
                                img: news.image,
                                des: news.description,
                                content: news.content,
                                date: news.updated_at
                            }
                        }}>
                            <img className="card-img-top" src={news.image} alt={news.title}></img>
                            <div className="card-body">
                                <h5 className="card-title">{news.title}</h5>
                                <p className="card-text">
                                    {news.description}
                                </p>
                            </div>
                            <div className="card-footer">
                                <small className="text-muted">{news.updated_at}</small>
                            </div>
                        </Link>
                    </div>
                )
            })
            return newsList;
        }
    }

    let list;
    let displayNews;

    if (data) {
        var splitArray = data.split("\r\n\r\n");
        const headers = splitArray[0];
        const body = splitArray[1];
        // setData1(JSON.parse(body));
        list = JSON.parse(body);
        console.log(list)
        displayNews = renderNews(list)
    }

    return (
        <div className="container">
            <h3>News</h3>
            {data
                ?
                <div className="row row-cols-1 row-cols-md-3">
                    {displayNews}
                </div>
                : <div>Loading news...</div>
            }
        </div>
    )
}

export default News;