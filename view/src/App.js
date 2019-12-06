import React from "react";
import "./App.css";
import { BrowserRouter as Router, Switch, Route } from "react-router-dom";
import Header from "./components/Header/header";
import Movies from "./components/Movies/Movies";
import HomePage from "./components/Home/HomePage";

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
                        {/* <HomePage /> */}
                    </Route>
                </Switch>
            </Router>
        </div>
    );
}

export default App;
