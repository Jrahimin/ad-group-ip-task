import axios from "axios";

export const AxiosReq = (url, data, callback, method = 'post', hasFile = false) => {
    let axiosOption = {
        method,
        url,
        data
    };

    axiosOption['headers'] = {
        'Authorization': `Bearer ${localStorage.getItem('authToken')}`
    }

    if (hasFile) {
        axiosOption['headers'] = {
            "Content-Type": "multipart/form-data"
        }
    }

    return axios(axiosOption).then((response) => {
        callback(response.data);
    }).catch((error) => {
        const errorResponse = error.response;
        if (errorResponse.status === 401) {
            const data = {
                code: 401,
                message: "You are not authenticated",
            }
            callback(data);

            return;
        }

        const data = {
            code: 500,
            message: "Something went wrong.",
        }
        callback(data);
    });
}
