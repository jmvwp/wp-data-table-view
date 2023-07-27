import "../sass/main.sass";
import React from "react";
import ReactDOM from "react-dom";
import App from "./App";

const initialState = window.mvwpWpDataTableView;
if (initialState) {
    const {data} = initialState;
    if (data) {
        ReactDOM.render(<App data={data}/>, document.getElementById("wp-data-table-template"));
    } else {
        console.error("mvwpWpDataTableView has wrong format.");
    }
} else {
    console.error("mvwpWpDataTableView is not defined in the window object.");
}