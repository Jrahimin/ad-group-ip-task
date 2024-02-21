import React, {useState} from 'react';
import {useNavigate} from 'react-router-dom';
import {AxiosReq} from "../shared/AxiosReq";
import {ApiEndpoints} from "../shared/ApiEndpoints";

function Login() {
    const navigate = useNavigate();
    const [credentials, setCredentials] = useState({email: '', password: ''});
    const [errorMsg, setErrorMessage] = useState('');

    const handleCredentials = (e) => {
        const {name, value} = e.target;
        setCredentials(prevCredentials => ({
            ...prevCredentials,
            [name]: value
        }));
    }

    const onSubmit = (e) => {
        e.preventDefault();
        setErrorMessage('');

        AxiosReq(ApiEndpoints.LOGIN, credentials, (response) => {
            if (response.code !== 200) {
                setErrorMessage(response.message);
                return;

            }
            const data = response.data.data;
            localStorage.setItem('authToken', data.token);

            navigate('/');
        }, 'post');
    }

    return (
        <div className="container">
            <div className="row justify-content-center">
                <div className="col-md-6">
                    <div className="card">
                        <div className="card-header">Login</div>
                        <div className="card-body">
                            <form onSubmit={onSubmit}>
                                <div className="form-group mb-3">
                                    <label htmlFor="email">Email</label>
                                    <input
                                        type="email"
                                        className="form-control"
                                        name="email"
                                        placeholder="Enter email"
                                        value={credentials.email}
                                        onChange={handleCredentials}
                                        required
                                    />
                                </div>

                                <div className="form-group mb-3">
                                    <label htmlFor="password">Password</label>
                                    <input
                                        type="password"
                                        className="form-control"
                                        name="password"
                                        placeholder="Password"
                                        value={credentials.password}
                                        onChange={handleCredentials}
                                        required
                                    />
                                </div>

                                <div className="d-flex justify-content-end">
                                    <button type="submit" className="btn btn-primary">Login</button>
                                </div>

                                {errorMsg && <div className="text-danger mt-2">{errorMsg}</div>}
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default Login;