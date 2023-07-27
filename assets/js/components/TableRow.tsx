import React from "react";
import {Column, User} from "../ts/interfaces/data";
import IconControl from "./IconControl";

interface TableRowProps {
    rowData: User
    columnsToDisplay: Column[],
    rowClickHandler: (rowId: number, event: React.MouseEvent<HTMLElement>) => void;
    isActive: boolean
    resetRowHandler: (event: React.MouseEvent<HTMLElement>) => void;
}

const TableRow: React.FC<TableRowProps> = (
    {
        isActive,
        rowData,
        columnsToDisplay,
        rowClickHandler,
        resetRowHandler
    }) => {

    const controlHandler = isActive ?
        (event: React.MouseEvent<HTMLElement>) => resetRowHandler(event) :
        (event: React.MouseEvent<HTMLElement>) => rowClickHandler(rowData.id, event)
    return (
        <tr className="row">
            <td className="control">
                <IconControl opened={isActive} clickHandler={controlHandler}/>
            </td>
            {columnsToDisplay.map(col =>
                <td><a onClick={controlHandler}
                       href="#">{rowData[col.key] ? rowData[col.key].toString() : ''}</a></td>
            )}
        </tr>
    );
};

export default TableRow;