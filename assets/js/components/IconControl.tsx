import React from "react";

interface IconControl {
    opened?: boolean
    clickHandler: (event: React.MouseEvent<HTMLElement>) => void;
}

const IconControl: React.FC<IconControl> = ({opened, clickHandler}) => {
    return (
        <div onClick={(event)=>clickHandler(event)}
             className={`icon icon-${opened ? 'minus' : 'plus'}`}></div>
    );
};

export default IconControl;