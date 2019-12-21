import React from "react";
import ReactDOM from 'react-dom';
import { BrowserRouter as Router, Switch, Route } from "react-router-dom";
import Header from "./components/Header/header";
import Movies from "./components/Movies/Movies";
import HomePage from "./components/Home/HomePage";
import MovieDetail from "./components/Movies/MovieDetail";

function App() {
    return (
        <div className="App">
            <Router>
                <Header />
                <Switch>
                    <Route exact path="/">
                        <HomePage/>
                    </Route>
                    <Route exact path="/movies">
                        <Movies/>
                    </Route>
                    <Route exact path="/news">
                        {/* <MovieDetail /> */}
                    </Route>
                    <Route exact path="/movie/:id" component={MovieDetail}/>
                </Switch>
            </Router>
        </div>
    );
}

export default App;

if (document.getElementById('test')) {
    ReactDOM.render(<App />, document.getElementById('test'));
}
