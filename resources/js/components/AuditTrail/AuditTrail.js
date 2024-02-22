import React, {useEffect, useState} from 'react';
import {AxiosReq} from "../shared/AxiosReq";
import {ApiEndpoints} from "../shared/ApiEndpoints";
import {useNavigate} from "react-router-dom";

function AuditTrail() {
    const navigate = useNavigate();
    const [auditData, setAuditData] = useState([]);
    const [errorMsg, setErrorMessage] = useState('');

    useEffect(() => {
        if (!localStorage.getItem('authToken')) {
            navigate('/login');
            return;
        }

        fetchAuditTrail();
    }, []);

    const fetchAuditTrail = () => {
        AxiosReq(ApiEndpoints.AUDIT, {}, (response) => {
            if (response.code === 401) {
                navigate('/login');
                return;
            }

            if (response.code === 200) {
                setAuditData(response.data.data);
            } else {
                setErrorMessage(response.message);
            }
        }, 'get');
    };

    return (
        <div className="container">
            <div className="row justify-content-center">
                <div className="col-md-10">
                    {errorMsg && <div className="alert alert-danger">{errorMsg}</div>}
                    <table className="table table-bordered mt-3">
                        <thead className="thead-light">
                        <tr>
                            <th>Action Type</th>
                            <th>User Email/IP Address</th>
                            <th>Old Label</th>
                            <th>New Label</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        {auditData.map((audit) => (
                            <tr key={audit.id}>
                                <td>{audit.action_type_label}</td>
                                <td>{audit.auditable.email || audit.auditable.ip_address}</td>
                                <td>{audit.old_label || 'n/a'}</td>
                                <td>{audit.new_label || 'n/a'}</td>
                                <td>{new Date(audit.created_at).toLocaleString()}</td>
                            </tr>
                        ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    );
}

export default AuditTrail;

