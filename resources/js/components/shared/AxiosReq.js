import axios from "axios";

export const AxiosReq = (url, data, callback, method='post', hasFile=false) => {
    let axiosOption = {
        method,
        url,
        data
    };

    if(hasFile){
        axiosOption['headers'] = {
            "Content-Type": "multipart/form-data"
        }
    }

    return axios(axiosOption).then((response) => {
        console.log('data', response.data);
        callback(response.data);
    }).catch((error) => {
        console.log('error', error);
        const data = {
            code: 500,
            message: "Something went wrong.",
        }
        callback(data);
    });
}
