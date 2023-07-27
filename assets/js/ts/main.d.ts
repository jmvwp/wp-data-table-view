import {Data} from "./interfaces/data";
import {Rest} from "./interfaces/rest";
import {ROW_STATUS_ERROR, ROW_STATUS_LOADED, ROW_STATUS_LOADING, ROW_STATUS_NOT_EXIST} from "../constants/rowStatus";

export interface InitialState {
    data: Data;
    rest: Rest;
}

interface DataObject {
    [key: string]: string | number | DataObject | null;
}



export type RowStatus =
    typeof ROW_STATUS_ERROR
    | typeof ROW_STATUS_LOADING
    | typeof ROW_STATUS_LOADED
    | typeof ROW_STATUS_NOT_EXIST

declare global {
    interface Window {
        mvwpWpDataTableView: InitialState
    }
}
