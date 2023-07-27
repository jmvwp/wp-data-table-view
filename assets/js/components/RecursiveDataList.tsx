import React from 'react';
import {capitalizeFirstLetter} from "../utils/strings";
import {DataObject} from "../ts/main";

interface RecursiveDataList {
    data: DataObject
}

const RecursiveDataList: React.FC<RecursiveDataList> = ({data}) => {

    return (
        <ul>
            {Object.keys(data).map((key) => {
                const value = data[key];
                if (typeof value === 'object' && value !== null) {
                    return (
                        <li key={key}>
                            {capitalizeFirstLetter(key)}:
                            <RecursiveDataList data={value}/>
                        </li>
                    );
                } else {
                    return (
                        <li key={key}>
                            {capitalizeFirstLetter(key)}: {value}
                        </li>
                    );
                }
            })}
        </ul>
    );
};

export default RecursiveDataList;
