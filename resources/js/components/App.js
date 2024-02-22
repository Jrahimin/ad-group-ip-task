import React from 'react';
import ReactDOM from 'react-dom';
import {BrowserRouter, Route, Routes} from "react-router-dom";
import Navbar from './Navbar';
import Login from "./login/Login";
import IPManagement from "./Ip/ManageIp";
import AuditTrail from "./AuditTrail/AuditTrail";

function App() {
    return (
        <>
            <BrowserRouter>
                <Navbar/>
                <br/>
                <Routes>
                    <Route path="/" element={<IPManagement />} />
                    <Route path="/audit" element={<AuditTrail />} />
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
