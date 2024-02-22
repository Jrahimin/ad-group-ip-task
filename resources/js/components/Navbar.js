import React from 'react';
import {Link, useNavigate} from 'react-router-dom';

function Navbar() {
    const navigate = useNavigate();

    const logout = () => {
        localStorage.removeItem('authToken');
        navigate('/login');
    };

    return (
        <nav className="navbar navbar-expand-lg navbar-light bg-secondary">
            <div className="collapse navbar-collapse" id="navbarSupportedContent">
                <ul className="navbar-nav mr-auto">
                    <li className="nav-item active">
                        <Link className="nav-link text-white" to="/login">Login</Link>
                    </li>
                    <li className="nav-item active">
                        <Link className="nav-link text-white" to="/">Manage IP</Link>
                    </li>
                    <li className="nav-item active">
                        <Link className="nav-link text-white" to="/audit">Audit Trail</Link>
                    </li>
                </ul>
                <button onClick={logout} className="btn btn-danger mr-2" style={{marginLeft: 'auto'}}>Logout</button>
            </div>
        </nav>
    );
}

export default Navbar;
