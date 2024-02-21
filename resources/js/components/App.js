import React from 'react';
import ReactDOM from 'react-dom';
import {BrowserRouter, Route, Routes} from "react-router-dom";
import Navbar from './Navbar';
import Login from "./login/Login";
import IPManagement from "./Ip/ManageIp";

function App() {
    return (
        <>
            <BrowserRouter>
                <Navbar/>
                <br/>
                <Routes>
                    <Route path="/" element={<IPManagement />} />
                    <Route path="/login" element={<Login />} />
                </Routes>
            </BrowserRouter>
        </>
    );
}

export default App;

if (document.getElementById('app')) {
    ReactDOM.render(<App />, document.getElementById('app'));
}
