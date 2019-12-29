import React from "react";
import ReactDOM from 'react-dom';
import { BrowserRouter as Router, Switch, Route } from "react-router-dom";
import Header from "./components/Header/header";
import Movies from "./components/Movies/Movies";
import MoviesInDb from "./components/Movies/MoviesInDb";
import HomePage from "./components/Home/HomePage";
import MovieDetail from "./components/Movies/MovieDetail";
import News from './components/News/News';
import NewsDetail from './components/News/NewsDetail';
import Footer from "./components/Footer/Footer";

function App() {
    return (
        <div className="App">
            <Router>
                <Header />
                <Switch>
                    <Route exact path="/">
                        <HomePage/>
                    </Route>
                    <Route exact path="/listmovies">
                        <MoviesInDb/>
                    </Route>
                    <Route exact path="/news">
                        <News/>
                    </Route>
                    <Route exact path="/movie/:id" component={MovieDetail}/>
                    <Route exact path="/news/:id" component={NewsDetail}/>
                </Switch>
                <Footer/>
            </Router>
        </div>
    );
}

export default App;

if (document.getElementById('test')) {
    ReactDOM.render(<App />, document.getElementById('test'));
}
