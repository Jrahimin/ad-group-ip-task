import React, {useEffect, useState} from 'react';
import {useNavigate} from 'react-router-dom';
import {AxiosReq} from "../shared/AxiosReq";
import {ApiEndpoints} from "../shared/ApiEndpoints";
import '../../../css/ip.css';

function IPManagement() {
    const navigate = useNavigate();
    const [ipData, setIpData] = useState([]);
    const [newIp, setNewIp] = useState({ip_address: '', label: ''});
    const [editingLabels, setEditingLabels] = useState({});
    const [errorMsg, setErrorMessage] = useState('');
    const [successMsg, setSuccessMsg] = useState('');

    useEffect(() => {
        if (!localStorage.getItem('authToken')) {
            navigate('/login');
            return;
        }

        fetchIps();
    }, []);

    const fetchIps = () => {
        AxiosReq(ApiEndpoints.IP, {}, (response) => {
            if (response.code === 401) {
                navigate('/login');
                return;
            }

            if (response.code === 200) {
                setIpData(response.data.data);
            } else {
                setErrorMessage(response.message);
            }
        }, 'get');
    };

    const handleNewIpChange = (e) => {
        const {name, value} = e.target;
        setNewIp(prevState => ({
            ...prevState,
            [name]: value
        }));
    };

    const handleLabelChange = (id, value) => {
        setEditingLabels(prevLabels => ({
            ...prevLabels,
            [id]: value
        }));
    };

    const addIp = (e) => {
        e.preventDefault();
        AxiosReq(ApiEndpoints.IP, newIp, (response) => {
            if (response.code === 200) {
                fetchIps();
                setNewIp({ip_address: '', label: ''});
                setErrorMessage('');
                setSuccessMsg(response.message);
            } else {
                setErrorMessage(response.message);
                setSuccessMsg('');
            }
        });
    };

    const updateIp = (id) => {
        const label = editingLabels[id];
        AxiosReq(`${ApiEndpoints.IP}/${id}`, {label}, (response) => {
            if (response.code !== 200) {
                setErrorMessage(response.message);
                setSuccessMsg('');
                return;
            }

            setSuccessMsg(response.message)
        }, 'put');
    };

    return (
        <div className="container">
            <div className="row justify-content-center">
                <div className="col-md-8">
                    <form onSubmit={addIp} className="add-ip-form">
                        <div className="form-row align-items-center">
                            <div className="col-auto">
                                <input
                                    type="text"
                                    className="form-control mb-2"
                                    name="ip_address"
                                    placeholder="Enter IP Address"
                                    value={newIp.ip_address}
                                    onChange={handleNewIpChange}
                                    required
                                />
                            </div>
                            <div className="col-auto">
                                <input
                                    type="text"
                                    className="form-control mb-2"
                                    name="label"
                                    placeholder="Enter Label"
                                    value={newIp.label}
                                    onChange={handleNewIpChange}
                                    required
                                />
                            </div>
                            <div className="col-auto">
                                <button type="submit" className="btn btn-primary mb-2">Add IP</button>
                            </div>
                        </div>
                        {successMsg && <div className="text-success mt-2">
                            <span>{successMsg}</span>
                        </div>}
                    </form>
                    {errorMsg && <div className="alert alert-danger">{errorMsg}</div>}
                    <table className="table table-bordered mt-3">
                        <thead className="thead-light">
                        <tr>
                            <th>IP Address</th>
                            <th>Label</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        {ipData.map((item) => (
                            <tr key={item.id}>
                                <td>{item.ip_address}</td>
                                <td>
                                    <input
                                        type="text"
                                        className="form-control"
                                        defaultValue={item.label}
                                        onChange={(e) => handleLabelChange(item.id, e.target.value)}
                                    />
                                </td>
                                <td>
                                    <button onClick={() => updateIp(item.id)} className="btn btn-sm btn-info">
                                        Update
                                    </button>
                                </td>
                            </tr>
                        ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
}

export default IPManagement;
