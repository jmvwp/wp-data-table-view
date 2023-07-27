import React from "react";
import {Column, User} from "../ts/interfaces/data";
import TableRow from "./TableRow";
import InfoRow from "./InfoRow";
import {RowStatus} from "../ts/main";

interface TableProps {
    rowsData: User[]
    columnsToDisplay: Column[];
    activeRow: number;
    activeRowStatus: RowStatus;
    activeRowData: User | null;
    rowClickHandler: (rowId: number, event: React.MouseEvent<HTMLElement>) => void;
    resetActiveRow: (event: React.MouseEvent<HTMLElement>) => void;
}

const Table: React.FC<TableProps> = (
    {
        rowsData,
        columnsToDisplay,
        activeRow,
        activeRowData,
        activeRowStatus,
        rowClickHandler,
        resetActiveRow
    }) => {

    return (
        <table>{
            rowsData ? (
                    <>
                        <thead>
                        <tr>
                            <th className="control"></th>
                            {columnsToDisplay.map(column => <th>{column.title}</th>)}
                        </tr>
                        </thead>
                        <tbody>
                        {
                            rowsData.map(row => {
                                let isActive = activeRow === row.id;
                                let rowComponent = <TableRow
                                    isActive={isActive}
                                    rowData={row}
                                    columnsToDisplay={columnsToDisplay}
                                    rowClickHandler={rowClickHandler}
                                    resetRowHandler={resetActiveRow}/>
                                let infoComponent = null;
                                if (isActive) {
                                    infoComponent = <InfoRow
                                        columnsAmount={columnsToDisplay.length}
                                        activeRowData={activeRowData}
                                        activeRowStatus={activeRowStatus}
                                    />
                                }
                                return (
                                    <>
                                        {rowComponent}
                                        {infoComponent}
                                    </>
                                )
                            })
                        }
                        </tbody>
                    </>
                )
                :
                <></>}
        </table>
    );
};

export default Table;