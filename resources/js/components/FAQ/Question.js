import React from "react";

import skin from '../../../images/icons8-skin-80.png';
import dropdown from '../../../images/icons8-triangle-30.png';

function Question(props) {
    return (
        <div className="p-2 w-1/2 m-2 ml-auto mr-auto rounded bg-white cursor-pointer shadow-md">
            <img className="w-9 inline-block" src={props.image} alt={'Skin icon'}/>
            <p className="ml-4 inline-block text-xl align-middle">{props.name}</p>
            <img className="w-9 mr-6 float-right inline-block" src={dropdown} alt={'Dropdown icon'}/>
        </div>
    );
}

export default Question;
