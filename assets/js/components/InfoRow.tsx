import React from "react";
import {ROW_STATUS_ERROR, ROW_STATUS_LOADED, ROW_STATUS_LOADING} from "../constants/rowStatus";
import Loader from "./Loader";
import Error from "./Error";
import {User} from "../ts/interfaces/data";
import {RowStatus} from "../ts/main";
import RecursiveDataList from "./RecursiveDataList";
import {convertObjectToDataObject} from "../utils/api";

interface InfoRow {
    activeRowStatus: RowStatus;
    activeRowData: User | null;
    columnsAmount: number;
}

const InfoRow: React.FC<InfoRow> = ({columnsAmount, activeRowStatus, activeRowData}) => {
    let infoComponent = null;
    let tdClass = '';
    switch (activeRowStatus) {
        case ROW_STATUS_LOADING:
            tdClass = 'loading';
            infoComponent = <Loader/>
            break;
        case ROW_STATUS_ERROR:
            tdClass = 'error';
            infoComponent = <Error/>
            break;
        case ROW_STATUS_LOADED:
            if (activeRowData) {
                infoComponent = <RecursiveDataList data={convertObjectToDataObject(activeRowData)}/>
            } else {
                infoComponent = <Error/>
            }
            break;
    }

    return <tr>
        <td className="control">
        </td>
        <td className={`info-cell ${tdClass}`} colSpan={columnsAmount}>
            {infoComponent}
        </td>
    </tr>;
};

export default InfoRow;