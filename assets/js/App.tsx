import React, {useState} from "react";
import {Data, User} from "./ts/interfaces/data";
import Table from "./components/Table";
import {RowStatus} from "./ts/main";
import {ROW_STATUS_ERROR, ROW_STATUS_LOADED, ROW_STATUS_LOADING, ROW_STATUS_NOT_EXIST} from "./constants/rowStatus";
import {getHeaders, getRequestUrl} from "./utils/api";

interface AppProps {
    data: Data;
}

const App: React.FC<AppProps> = ({data}) => {

    const [activeRow, setActiveRow] = useState<number>(-1)
    const [activeRowData, setActiveRowData] = useState<User | null>(null)
    const [activeRowStatus, setActiveRowStatus] = useState<RowStatus>(ROW_STATUS_NOT_EXIST)
    const resetActiveRow = (event: React.MouseEvent<HTMLElement>) => {
        event.preventDefault();
        event.stopPropagation();
        setActiveRow(-1);
        setActiveRowStatus(ROW_STATUS_NOT_EXIST);
        setActiveRowData(null);
    }
    const handleFetchData = async (rowId: number, event: React.MouseEvent<HTMLElement>) => {
        event.preventDefault();
        event.stopPropagation();
        setActiveRow(rowId)
        setActiveRowStatus(ROW_STATUS_LOADING);
        try {
            const response = await fetch(getRequestUrl(rowId), {
                method: 'GET',
                headers: getHeaders(),
                credentials: 'include'
            });
            const data = await response.json();
            if (data) {
                setActiveRowData(data);
                setActiveRowStatus(ROW_STATUS_LOADED);
            } else {
                setActiveRowStatus(ROW_STATUS_ERROR);
                setActiveRowData(null);
            }
        } catch (error) {
            setActiveRowStatus(ROW_STATUS_ERROR);
            setActiveRowData(null);
        }
    };


    return (
        data.users && Array.isArray(data.users) ?
            <Table
                rowsData={data.users}
                columnsToDisplay={data.columns}
                activeRow={activeRow}
                activeRowStatus={activeRowStatus}
                activeRowData={activeRowData}
                rowClickHandler={handleFetchData}
                resetActiveRow={resetActiveRow}
            /> :
            <p className="error-text no-data">No
                Data provided</p>
    );
}
export default App;