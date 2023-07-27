import {User} from "../ts/interfaces/data";
import {DataObject} from "../ts/main";

export const getRequestUrl = (userId: number) => {

    let rest = getRestConfig();
    return `${rest.url}${rest.namespace}/${rest.rest_base}/get-entity/${userId}`
}
export const getHeaders = () => {
    let rest = getRestConfig();
    const headers = new Headers();
    headers.append('X-WP-Nonce', rest.nonce);
    headers.append('Content-Type', 'application/json');
    return headers;
}
const getRestConfig = () => {
    const initialState = window.mvwpWpDataTableView;
    const {rest} = initialState;
    return rest;
}

export const convertObjectToDataObject = (obj: { [key: string]: any }): DataObject | {} => {
    let data: DataObject = {} as DataObject;
    Object.keys(obj).forEach((key) => {
        if (obj.hasOwnProperty(key)) {
            const value = obj[key];
            if (typeof value === 'object' && value !== null) {
                data[key] = convertObjectToDataObject(value as object) as DataObject;
            } else {
                data[key] = value ? value.toString() : '';
            }
        }
    });
    return data;
};