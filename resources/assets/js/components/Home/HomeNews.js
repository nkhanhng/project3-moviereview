import React, { useEffect, useState } from 'react';
import config from '../../config/config.json';
import axios from 'axios';
import { Modal } from 'react-bootstrap'
import Loading from '../Loading/Loading';

const HomeNews = props => {
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
                    <div key={news.id} className="card" onClick={()=>setShowModal(true)}>
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
                        <div onClick={e => e.stopPropagation()}>
                            <Modal
                                size="lg"
                                show={showModal}
                                onHide={() => setShowModal(false)}
                                dialogClassName="modal-90w"
                                aria-labelledby="example-custom-modal-styling-title"
                            >
                                <Modal.Header closeButton>
                                    <Modal.Title id="example-modal-sizes-title-lg">
                                        {news.title}
                                    </Modal.Title>
                                </Modal.Header>
                                <Modal.Body>
                                        <img className="card-img-top" src={news.image} alt={news.title}></img>
                                    {news.content}
                                </Modal.Body>
                            </Modal>
                        </div>
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
        displayNews = renderNews(list)
    }

    return (
        <div className="">
            <h3>News</h3>
            {displayNews
            ?
                <div className="card-group">
                    {displayNews}
                </div>
            :   <Loading/>
            }
        </div>
    )
}

export default HomeNews;